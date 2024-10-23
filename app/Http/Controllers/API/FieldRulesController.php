<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Requests\FieldRulesSaveRequest;
use App\Http\Resources\FieldRuleResource;
use App\Models\FieldRule;

class FieldRulesController
{
    public function index()
    {
        return FieldRuleResource::collection(FieldRule::all());
    }

    public function store(FieldRulesSaveRequest $request)
    {
        return new FieldRuleResource(FieldRule::create($request->validated()));
    }

    public function show(FieldRule $fieldRule)
    {
        return new FieldRuleResource($fieldRule);
    }

    public function update(FieldRulesSaveRequest $request, FieldRule $fieldRule)
    {
        $fieldRule->update($request->validated());

        return new FieldRuleResource($fieldRule);
    }

    public function destroy(FieldRule $fieldRule)
    {
        $fieldRule->delete();

        return response()->json();
    }
}
