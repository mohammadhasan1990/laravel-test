<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSiteRequest;
use App\Http\Requests\UpdateSiteRequest;
use App\Models\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        return Site::query()
            ->where('owner_id', auth()->id())
            ->paginate();
    }

    public function store(CreateSiteRequest $request)
    {
        return Site::query()->create($request->validated());
    }

    public function update($id, UpdateSiteRequest $request)
    {
        $site = Site::query()->findOrFail($id);
        $site->title = $request->title;
        $site->address = $request->address;
        $site->save();

        return response(status: 202);
    }

    public function destroy($id)
    {
        $site = Site::query()
            ->where('owner_id', auth()->id())
            ->findOrFail($id);

        $site->delete();

        return response(status: 204);
    }
}
