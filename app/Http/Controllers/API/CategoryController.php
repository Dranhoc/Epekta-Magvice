<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Requests\CategorySaveRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Support\SpatieQueryBuilder\Sorts\FieldSort;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryController
{
    public function index(Request $request): CategoryCollection
    {
        $categories = QueryBuilder::for(Category::class)
            ->allowedFilters(['id', AllowedFilter::scope('parentCategory'), AllowedFilter::exact('category_id')])
            ->defaultSort('id')
            ->allowedSorts(['id', 'email', AllowedSort::custom('ids_field', new FieldSort, 'id')])
            ->allowedIncludes(['categories'])
            ->paginate($request->get('per_page', 15))
            ->appends($request->query());

        return new CategoryCollection($categories);
    }

    public function store(CategorySaveRequest $request): CategoryResource
    {
        $category = Category::create($request->validated());

        $category->parent()->associate($request->get('category'));

        $category->save();

        return (new CategoryResource($category))->withAutoLoadRelations($request->get('include'));
    }

    public function show(Request $request, Category $category): CategoryResource
    {
        return (new CategoryResource($category))->withAutoLoadRelations($request->get('include'));
    }

    public function update(CategorySaveRequest $request, Category $category): CategoryResource
    {
        $category->update($request->validated());

        $category->parent()->associate($request->get('category'));

        $category->save();

        return (new CategoryResource($category))->withAutoLoadRelations($request->get('include'));
    }

    public function destroy(Category $category): Response
    {
        $category->delete();

        return response()->noContent();
    }
}
