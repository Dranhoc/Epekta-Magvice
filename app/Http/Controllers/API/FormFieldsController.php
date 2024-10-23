<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Requests\FormFieldSaveRequest;
use App\Http\Resources\FormFieldCollection;
use App\Http\Resources\FormFieldResource;
use App\Models\FieldOption;
use App\Models\FieldRule;
use App\Models\FormField;
use App\Support\SpatieQueryBuilder\Sorts\FieldSort;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class FormFieldsController
{
    public function index(Request $request): FormFieldCollection
    {
        $formFields = QueryBuilder::for(FormField::class)
            ->allowedFilters(['id'])
            ->defaultSort('id')
            ->allowedSorts(['id', AllowedSort::custom('ids_field', new FieldSort, 'id')])
            ->allowedIncludes(['options'])
            ->paginate($request->get('per_page', 15))
            ->appends($request->query());

        return new FormFieldCollection($formFields);
    }

    public function store(FormFieldSaveRequest $request): FormFieldResource
    {
        $formField = FormField::create($request->validated());

        $formField->save();

        return (new FormFieldResource($formField))->withAutoLoadRelations($request->get('include'));
    }

    public function show(Request $request, FormField $formField)
    {
        return (new FormFieldResource($formField))->withAutoLoadRelations($request->get('include'));
    }

    public function update(FormFieldSaveRequest $request, FormField $formField): FormFieldResource
    {
        $formField->update($request->validated());

        if ($request->get('options')) {
            foreach ($request->get('options') as $option) {
                if (isset($option['id'])) {
                    FieldOption::where('id', $option['id'])->update([
                        'label' => $option['label'],
                        'price' => $option['price'],
                        'amount' => $option['amount'],
                    ]);
                } else {
                    $formField->options()->create([
                        'label' => $option['label'],
                        'price' => $option['price'],
                        'amount' => $option['amount'],
                    ]);
                }
            }
        }

        if ($request->get('rules')) {
            foreach ($request->get('rules') as $rule) {
                if (isset($rule['operator']) && isset($rule['option'])) {
                    if (isset($rule['id'])) {
                        $fieldRule = FieldRule::where('id', $rule['id'])->first();
                        $fieldRule->update([
                            'operator' => $rule['operator']['id'],
                        ]);
                        $fieldRule->option()->associate($rule['option']['id']);
                        $fieldRule->save();
                    } else {
                        $formField->rules()->create([
                            'operator' => $rule['operator']['id'],
                            'field_option_id' => $rule['option']['id'],
                        ]);

                        $formField->save();
                    }
                }
            }
        }

        $formField->save();

        return (new FormFieldResource($formField))->withAutoLoadRelations($request->get('include'));
    }

    public function destroy(FormField $formField): \Illuminate\Http\JsonResponse
    {
        foreach ($formField->options as $option) {
            $option->rules()->delete();
        }
        $formField->options()->delete();
        $formField->delete();

        return response()->json();
    }
}
