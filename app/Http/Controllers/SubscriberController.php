<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscribeRequest;
use App\Models\Site;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index()
    {
        return Site::query()
            ->whereHas('subscribes', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->paginate();
    }

    public function subscribe(SubscribeRequest $request)
    {
        $site = Site::query()->where('address', $request->address)->firstOrFail();
        auth()->user()->subscribes()->syncWithoutDetaching([$site->id]);

        return response(status: 204);
    }
}
