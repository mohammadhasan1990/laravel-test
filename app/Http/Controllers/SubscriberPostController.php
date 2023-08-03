<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class SubscriberPostController extends Controller
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
            ->whereHas('site', function ($query) {
                $query->whereHas('subscribes', function ($query) {
                    $query->where('user_id', auth()->id());
                });
            })
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
}
