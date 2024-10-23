<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Actions\FormResponse\ExportXLSX;
use App\Http\Requests\FormSaveRequest;
use App\Http\Resources\FormCollection;
use App\Http\Resources\FormResource;
use App\Models\Form;
use App\Support\SpatieQueryBuilder\Sorts\FieldSort;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class FormController
{
    public function index(Request $request): FormCollection
    {
        $forms = QueryBuilder::for(Form::class)
            ->allowedFilters(['id'])
            ->defaultSort('id')
            ->allowedSorts(['id', AllowedSort::custom('ids_field', new FieldSort, 'id')])
            ->allowedIncludes(['steps', 'steps.sections', 'steps.sections.fields'])
            ->paginate($request->get('per_page', 15))
            ->appends($request->query());

        return new FormCollection($forms);
    }

    public function store(FormSaveRequest $request): FormResource
    {
        $form = Form::create($request->validated());
        $form->steps()->create(['name' => ['fr' => 'étape 1', 'en' => 'step 1']]);
        $form->save();

        return (new FormResource($form))->withAutoLoadRelations($request->get('include'));
    }

    public function show(Request $request, Form $form): FormResource
    {
        return (new FormResource($form))->withAutoLoadRelations($request->get('include'));
    }

    public function update(FormSaveRequest $request, Form $form): FormResource
    {
        $form->update($request->validated());

        return (new FormResource($form))->withAutoLoadRelations($request->get('include'));
    }

    public function destroy(Form $form): JsonResponse
    {
        foreach ($form->steps as $step) {
            foreach ($step->sections as $section) {
                foreach ($section->fields as $field) {
                    $field->options()->delete();
                }
                $section->fields()->delete();
            }
            $step->sections()->delete();
        }

        $form->steps()->delete();
        $form->delete();

        return response()->json();
    }

    public function addStep(Form $form, Request $request): FormResource
    {
        $form->steps()->create(['name' => ['fr' => 'étape '.$form->steps->count() + 1, 'en' => 'step '.$form->steps->count() + 1]]);
        $form->save();

        return (new FormResource($form))->withAutoLoadRelations($request->get('include'));
    }

    public function export(Form $form): JsonResponse
    {
        $url = app(ExportXLSX::class)->execute($form)->getFullUrl();

        return response()->json([
            'data' => [
                'url' => $url,
            ],
        ]);
    }
}
