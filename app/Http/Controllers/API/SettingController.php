<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Requests\SettingSaveRequest;
use App\Http\Resources\BaseResource;
use App\Http\Resources\SettingCollection;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
use App\Support\SpatieQueryBuilder\Sorts\FieldSort;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class SettingController
{
    public function index(Request $request): SettingCollection
    {
        $settings = QueryBuilder::for(Setting::class)
            ->allowedFilters(['id', 'name'])
            ->defaultSort('id')
            ->allowedSorts(['id', 'name', AllowedSort::custom('ids_field', new FieldSort, 'id')])
            ->allowedIncludes(['status'])
            ->paginate($request->get('per_page', 15))
            ->appends($request->query());

        return new SettingCollection($settings);
    }

    public function store(SettingSaveRequest $request): BaseResource
    {
        $setting = Setting::create($request->validated());

        $setting->save();

        return (new SettingResource($setting))->withAutoLoadRelations($request->get('include'));
    }

    public function show(Setting $setting, Request $request): BaseResource
    {
        return (new SettingResource($setting))->withAutoLoadRelations($request->get('include'));
    }

    public function update(SettingSaveRequest $request, Setting $setting): BaseResource
    {
        $data = $request->validated();

        $setting->update($data);

        return (new SettingResource($setting))->withAutoLoadRelations($request->get('include'));
    }

    public function destroy(Setting $setting): JsonResponse
    {
        $setting->delete();

        return response()->json(['data' => $setting->getKey()]);
    }
}
