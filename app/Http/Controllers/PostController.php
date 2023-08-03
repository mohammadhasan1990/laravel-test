<?php

namespace App\Http\Controllers;

use App\Events\PostPublished;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Jobs\SendPublishedPostToNotReceivedUsersJob;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        return Post::query()
            ->with(['owner' => function ($query) {
                $query->select(['id', 'name', 'email']);
            }])
            ->when(!$request->get('site_id'), function ($query) {
                $query->with(['site' => function ($query) {
                    $query->select(['id', 'title', 'address']);
                }]);
            })
            ->when($request->get('title'), function ($query) use ($request) {
                $query->where('title', 'LIKE', "%{$request->title}%");
            })
            ->when($request->get('is_published'), function ($query) use ($request) {
                $query->where('is_published', $request->is_published);
            })
            ->when($request->get('orderBy'), function ($query) use ($request) {
                $query->orderBy($request->orderBy, $request->get('direction', 'asc'));
            })
            ->when($request->get('site_id'), function ($query) use ($request) {
                $query->where('site_id', $request->site_id);
            })
            ->where('owner_id', auth()->id())
            ->paginate();
    }

    public function indexOfSpecifySite(Request $request, $siteId)
    {
        $request->merge(['site_id' => $siteId]);
        return $this->index($request);
    }

    public function latestIndex(Request $request)
    {
        $request->merge([
            'orderBy' => 'created_at',
            'direction' => 'desc'
        ]);

        return $this->index($request);
    }

    public function show($id)
    {
        return Post::query()->where('owner_id', auth()->id())->findOrFail($id);;
    }

    public function store(CreatePostRequest $request)
    {
        $post = Post::query()->create($request->validated());

        PostPublished::dispatchIf($post->is_published, $post);

        return $post;
    }

    public function update($id, UpdatePostRequest $request)
    {
        $post = Post::query()->where('owner_id', auth()->id())->findOrFail($id);

        $post->title = $request->title;
        $post->body = $request->body;
        $post->is_published = $request->is_published;

        $post->save();

        PostPublished::dispatchIf($post->is_published, $post);

        return response(status: 202);
    }

    public function destroy($id)
    {
        Post::query()->where('owner_id', auth()->id())->findOrFail($id)->delete();
        return response(status: 204);
    }

    public function prepareToSendToNotSentUsers()
    {
        SendPublishedPostToNotReceivedUsersJob::dispatch();
        return response(status: 204);
    }
}
