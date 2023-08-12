<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WatchHistoryController extends Controller
{
    public function __invoke(Request $request, Video $video): Response
    {
        $watchHistoryControl = $video->watchHistory()->firstOrCreate(
            [
                'channel_id' => $request->channelId
            ],
            [
                'video_id' => $video->id,
            ]
        );

        if ($watchHistoryControl->wasRecentlyCreated) {
            $video->increment('view_count');
        }

        return response()->noContent();
    }
}
