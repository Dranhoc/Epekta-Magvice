<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Requests\FieldOptionSaveRequest;
use App\Http\Resources\FieldOptionResource;
use App\Models\FieldOption;

class FieldOptionsController
{
    public function index()
    {
        return FieldOptionResource::collection(FieldOption::all());
    }

    public function store(FieldOptionSaveRequest $request)
    {
        return new FieldOptionResource(FieldOption::create($request->validated()));
    }

    public function show(FieldOption $fieldOption)
    {
        return new FieldOptionResource($fieldOption);
    }

    public function update(FieldOptionSaveRequest $request, FieldOption $fieldOption)
    {
        $fieldOption->update($request->validated());

        return new FieldOptionResource($fieldOption);
    }

    public function destroy(FieldOption $fieldOption)
    {
        $fieldOption->delete();

        return response()->json();
    }
}
