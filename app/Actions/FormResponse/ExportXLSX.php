<?php

declare(strict_types=1);

namespace App\Actions\FormResponse;

use App\Exports\FormResponsesExport;
use App\Models\Form;
use Barryvdh\DomPDF\PDF;
use Maatwebsite\Excel\Excel;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ExportXLSX
{
    protected PDF $pdf;

    public function execute(Form $form): Media
    {
        $name = 'export';

        $output = (new FormResponsesExport($form))->raw(Excel::XLSX);

        return $form->addMediaFromString($output)
            ->usingName($name)
            ->usingFileName("{$name}.xlsx")
            ->toMediaCollection('export');
    }
}
