<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Requests\FormSectionSaveRequest;
use App\Http\Resources\FormSectionCollection;
use App\Http\Resources\FormSectionResource;
use App\Models\FormField;
use App\Models\FormSection;
use App\Support\SpatieQueryBuilder\Sorts\FieldSort;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class FormSectionsController
{
    public function index(Request $request): FormSectionCollection
    {
        $formSections = QueryBuilder::for(FormSection::class)
            ->allowedFilters(['id'])
            ->defaultSort('id')
            ->allowedSorts(['id', AllowedSort::custom('ids_field', new FieldSort, 'id')])
            ->allowedIncludes(['fields'])
            ->paginate($request->get('per_page', 15))
            ->appends($request->query());

        return new FormSectionCollection($formSections);
    }

    public function store(FormSectionSaveRequest $request)
    {
        return new FormSectionResource(FormSection::create($request->validated()));
    }

    public function show(FormSection $formSection)
    {
        return new FormSectionResource($formSection);
    }

    public function update(FormSectionSaveRequest $request, FormSection $formSection)
    {
        $formSection->update($request->validated());

        return (new FormSectionResource($formSection))->withAutoLoadRelations($request->get('include'));
    }

    public function destroy(FormSection $formSection)
    {
        $formSection->delete();

        return response()->json();
    }

    public function addField(FormSection $formSection, Request $request)
    {
        $formSection->fields()->create([
            'name' => 'field-#'.$formSection->fields->count() + 1,
            'label' => ['fr' => 'champ '.$formSection->fields->count() + 1, 'en' => 'field '.$formSection->fields->count() + 1],
            'placeholder' => ['fr' => '', 'en' => ''],
            'tooltip' => ['fr' => '', 'en' => ''],
        ]);
        $formSection->save();

        return (new FormSectionResource($formSection))->withAutoLoadRelations($request->get('include'));
    }

    public function syncFields(FormSection $formSection, Request $request)
    {
        $formSection->fields()->each(function ($field) {
            return $field->section()->dissociate()->save();
        });
        collect($request->get('fields'))
            ->each(function ($id) use ($formSection) {
                return FormField::where('id', $id)->first()->section()->associate($formSection)->save();
            });
        $formSection->save();

        return (new FormSectionResource($formSection))->withAutoLoadRelations($request->get('include'));
    }
}
