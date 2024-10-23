<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Requests\FormStepSaveRequest;
use App\Http\Resources\FormStepCollection;
use App\Http\Resources\FormStepResource;
use App\Models\FormStep;
use App\Support\SpatieQueryBuilder\Sorts\FieldSort;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class FormStepsController
{
    public function index(Request $request): FormStepCollection
    {
        $formSteps = QueryBuilder::for(FormStep::class)
            ->allowedFilters(['id'])
            ->defaultSort('id')
            ->allowedSorts(['id', AllowedSort::custom('ids_field', new FieldSort, 'id')])
            ->allowedIncludes(['sections', 'sections.fields'])
            ->paginate($request->get('per_page', 15))
            ->appends($request->query());

        return new FormStepCollection($formSteps);
    }

    public function store(FormStepSaveRequest $request): FormStepResource
    {
        $formStep = FormStep::create($request->validated());
        $formStep->steps()->create(['name' => ['fr' => 'étape 1', 'en' => 'step 1']]);
        $formStep->save();

        return (new FormStepResource($formStep))->withAutoLoadRelations($request->get('include'));
    }

    public function show(Request $request, FormStep $formStep)
    {
        return (new FormStepResource($formStep))->withAutoLoadRelations($request->get('include'));
    }

    public function update(FormStepSaveRequest $request, FormStep $formStep)
    {
        $formStep->update($request->validated());

        return (new FormStepResource($formStep))->withAutoLoadRelations($request->get('include'));
    }

    public function destroy(FormStep $formStep)
    {
        $formStep->delete();

        return response()->json();
    }

    public function addSection(FormStep $formStep, Request $request)
    {
        $formStep->sections()->create(['name' => ['fr' => 'section '.$formStep->sections->count() + 1, 'en' => 'section '.$formStep->sections->count() + 1]]);
        $formStep->save();

        return (new FormStepResource($formStep))->withAutoLoadRelations($request->get('include'));
    }
}
