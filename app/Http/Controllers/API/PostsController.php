<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostSaveRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Support\SpatieQueryBuilder\Filters\GlobalFilter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use RahulHaque\Filepond\Facades\Filepond;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PostsController extends Controller
{
    public function index(Request $request): PostCollection
    {
        $posts = QueryBuilder::for(Post::class)
            ->allowedFilters(['id', AllowedFilter::custom('search', new GlobalFilter(['id']))])
            ->defaultSort('id')
            ->allowedSorts(['id'])
            ->allowedIncludes(['illustration'])
            ->when(
                $request->boolean('list'),
                fn ($query) => $query->get(),
                fn ($query) => $query->paginate($request->get('per_page', 15))->appends($request->query()),
            );

        return new PostCollection($posts);
    }

    public function store(PostSaveRequest $request): PostResource
    {
        $post = Post::create($request->validated());
        $post->save();

        $this->relations($request, $post);

        return (new PostResource($post))->withAutoLoadRelations($request->get('include'));
    }

    public function show(Post $post, Request $request): PostResource
    {
        return (new PostResource($post))->withAutoLoadRelations($request->get('include'));
    }

    public function update(PostSaveRequest $request, Post $post): PostResource
    {
        $data = $request->validated();

        $post->update($data);

        $this->relations($request, $post);

        return (new PostResource($post))->withAutoLoadRelations($request->get('include'));
    }

    public function destroy(Request $request, Post $post): JsonResponse
    {
        $post->delete();

        return response()->json(['data' => $post->getKey()]);
    }

    protected function relations(PostSaveRequest $request, Post $post): void
    {
        if ($request->get('illustration') && isset($request->get('illustration')[0])) {
            foreach (Filepond::field($request->get('illustration'))->getModel() ?? [] as $filepondFile) {
                $post->addMediaFromDisk($filepondFile->filepath)->preservingOriginal()->withResponsiveImages()->toMediaCollection('illustration');
            }
        }
    }
}
