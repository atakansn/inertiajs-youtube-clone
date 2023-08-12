<?php

namespace App\Http\Controllers\ChannelDashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChannelDashboard\VideoUpdateRequest;
use App\Models\Channel;
use App\Models\Video;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    public function index(Request $request, Channel $channel)
    {
        $videos = $channel->videos()
            ->when($request->input('search'), function (Builder $query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->cursorPaginate()
            ->withQueryString();

        return inertia('ChannelDashboard/Videos/Videos', [
            'videos' => $videos,
            'filters' => $request->only('search'),
        ]);
    }

    public function edit(Video $video)
    {
        return inertia('ChannelDashboard/Videos/Edit',[
            'video' => $video
        ]);
    }

    public function update(VideoUpdateRequest $request, Video $video)
    {
        $validatedData = $request->validated();

        $video->updateVideoThumbnail($validatedData['thumbnail']);

        unset($validatedData['thumbnail']);

        $video->update($validatedData);

        return back(303);
    }

    public function destroy(Request $request, Channel $channel)
    {
        if ($request->filled('ids')) {
            $channel->videos()->whereIn('id', $request->input('ids'))->delete();
            return back(303);
        }

        return back(303);
    }
}
