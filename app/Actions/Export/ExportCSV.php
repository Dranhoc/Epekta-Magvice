<?php

declare(strict_types=1);

namespace App\Actions\Export;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportCSV
{
    /**
     * @param  array<int, string>  $rows
     */
    public function export(string $modelClass, array $rows): StreamedResponse
    {
        $headers = $this->getHeaders();
        $callback = $this->getCallback($modelClass, $rows);

        return new StreamedResponse($callback, 200, $headers);
    }

    /**
     * @return array<string, string>
     */
    private function getHeaders(?string $fileName = 'export'): array
    {
        return [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename='.$fileName.'.csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];
    }

    /**
     * @param  array<int, string>  $rows
     */
    private function getCallback(string $modelClass, array $rows): callable
    {
        if (! class_exists($modelClass) || ! is_subclass_of($modelClass, Model::class)) {
            throw new \InvalidArgumentException("Invalid model class: {$modelClass}");
        }

        return function () use ($modelClass, $rows) {
            $file = fopen('php://output', 'wb');

            fputcsv($file, $rows);

            $models = $modelClass::query()->select($rows)->cursor();

            foreach ($models as $model) {
                fputcsv($file, $this->getModelAttributes($model, $rows));
            }

            fclose($file);
        };
    }

    /**
     * @param  array<int, string>  $rows
     * @return array<int, mixed>
     */
    private function getModelAttributes(Model $model, array $rows): array
    {
        $attributes = [];

        foreach ($rows as $row) {
            $attributes[] = $model->{$row};
        }

        return $attributes;
    }
}
