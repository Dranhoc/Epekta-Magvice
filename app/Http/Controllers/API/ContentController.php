<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Requests\ContentSaveRequest;
use App\Http\Resources\ContentCollection;
use App\Http\Resources\ContentResource;
use App\Models\Content;
use App\Support\SpatieQueryBuilder\Filters\GlobalFilter;
use App\Support\SpatieQueryBuilder\Sorts\FieldSort;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use RahulHaque\Filepond\Facades\Filepond;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class ContentController
{
    public function index(Request $request): ContentCollection
    {
        $contents = QueryBuilder::for(Content::class)
            ->allowedFilters([AllowedFilter::custom('search', new GlobalFilter([
                'title', 'source_file', 'content',
            ]))])
            ->defaultSort('id')
            ->allowedSorts(['id', 'title', 'page_id', AllowedSort::custom('ids_field', new FieldSort, 'id')])
            ->allowedIncludes(['picture', 'page'])
            ->paginate($request->get('per_page', 15))
            ->appends($request->query());

        return new ContentCollection($contents);
    }

    public function show(Content $content, Request $request): ContentResource
    {
        return (new ContentResource($content))->withAutoLoadRelations($request->get('include'));
    }

    public function store(ContentSaveRequest $request): ContentResource
    {
        $data = $request->validated();

        if (isset($data['body']['fr'])) {
            $data['body']['fr'] = str_replace('’', '\'', $data['body']['fr']);
        }

        $content = Content::create($request->validated());
        $content->page()->associate($request->get('page_id'));

        if ($request->get('picture') && isset($request->get('picture')[0])) {
            foreach (Filepond::field($request->get('picture'))->getModel() ?? [] as $filepondFile) {
                $content->addMediaFromDisk($filepondFile->filepath)->withResponsiveImages()->toMediaCollection('picture');
            }
        }

        $content->save();

        return (new ContentResource($content))->withAutoLoadRelations($request->get('include'));
    }

    public function update(ContentSaveRequest $request, Content $content): ContentResource
    {
        $data = $request->validated();

        if (isset($data['body']['fr'])) {
            $data['body']['fr'] = str_replace('’', '\'', $data['body']['fr']);
        }

        if ($request->get('picture') && isset($request->get('picture')[0])) {
            foreach (Filepond::field($request->get('picture'))->getModel() ?? [] as $filepondFile) {
                $content->addMediaFromDisk($filepondFile->filepath)->withResponsiveImages()->toMediaCollection('picture');
            }
        }

        $content->page()->associate($request->get('page_id'));
        $content->update($data);

        return (new ContentResource($content))->withAutoLoadRelations($request->get('include'));
    }

    public function destroy(Content $content): JsonResponse
    {
        $content->delete();

        return response()->json($content->getKey());
    }
}
