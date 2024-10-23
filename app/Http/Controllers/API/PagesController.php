<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\PageSaveRequest;
use App\Http\Resources\PageCollection;
use App\Http\Resources\PageResource;
use App\Models\Page;
use App\Support\SpatieQueryBuilder\Filters\GlobalFilter;
use App\Support\SpatieQueryBuilder\Sorts\FieldSort;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use RahulHaque\Filepond\Facades\Filepond;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class PagesController extends Controller
{
    public function index(Request $request): PageCollection
    {
        $pages = QueryBuilder::for(Page::class)
            ->allowedFilters(['id', 'title', AllowedFilter::custom('search', new GlobalFilter(['id', 'title']))])
            ->defaultSort('id')
            ->allowedSorts(['id', 'title', AllowedSort::custom('ids_field', new FieldSort, 'id')])
            ->when(
                $request->boolean('list'),
                fn ($query) => $query->get(),
                fn ($query) => $query->paginate($request->get('per_page', 15))->appends($request->query()),
            );

        return new PageCollection($pages);
    }

    public function store(PageSaveRequest $request): PageResource
    {
        $page = Page::create($request->validated());
        $page->save();
        $page->generateSlug();

        $this->relations($request, $page);

        return (new PageResource($page))->withAutoLoadRelations($request->get('include'));
    }

    public function show(Page $page, Request $request): PageResource
    {
        return (new PageResource($page))->withAutoLoadRelations($request->get('include'));
    }

    public function update(PageSaveRequest $request, Page $page): PageResource
    {
        $data = $request->validated();

        if ($page->slug !== 'home') {
            $page->generateSlug();
        }

        $page->update($data);

        $this->relations($request, $page);

        return (new PageResource($page))->withAutoLoadRelations($request->get('include'));
    }

    public function destroy(Request $request, Page $page): JsonResponse
    {
        $page->delete();

        return response()->json(['data' => $page->getKey()]);
    }

    public function removeSlider(Request $request): JsonResponse
    {
        $toRemoveUuId = $request->get('uuid');

        if ($toRemoveUuId) {
            Media::where('uuid', $toRemoveUuId)->delete();
        }

        return response()->json(['uuid' => $toRemoveUuId]);
    }

    public function moveSlider(Request $request): JsonResponse
    {
        Media::setNewOrder($request->get('ids'));

        return response()->json([
            'status' => 'Ok',
            'message' => __('Resource sorted !'),
        ]);
    }

    protected function relations(PageSaveRequest $request, Page $page): void
    {
        if ($request->get('seo_image') && isset($request->get('seo_image')[0])) {
            foreach (Filepond::field($request->get('seo_image'))->getModel() ?? [] as $filepondFile) {
                $page->addMediaFromDisk($filepondFile->filepath)->preservingOriginal()->withResponsiveImages()->toMediaCollection('seo_image');
            }
        }

        if ($request->get('slider') && isset($request->get('slider')[0])) {
            foreach (Filepond::field($request->get('slider'))->getModel() ?? [] as $filepondFile) {
                $page->addMediaFromDisk($filepondFile->filepath)->preservingOriginal()->withResponsiveImages()->toMediaCollection('slider');
            }
        }
    }
}
