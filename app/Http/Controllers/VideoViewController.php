<?php

namespace App\Http\Controllers;

use App\Enums\VideoPublished;
use App\Models\Video;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;

class VideoViewController extends Controller
{
    public function __invoke(Request $request)
    {
        return $request->whenFilled(
            'v', //Query
            function ($v) use ($request) {
                $findVideo = Video::with([
                    'channel' => ['subscriptions'],
                    'votes',
                    'watchHistory'
                ])->findOrFail($v);

                $commentsWithPaginate = $findVideo->comments()
                    ->with([
                        'user.channel',
                        'votes',
                        'replies'
                    ])
                    ->simplePaginate(5)
                    ->withQueryString();

                $allVideos = Video::with('channel')
                    ->where('id', '!=', $findVideo->id)
                    ->where('processing_percentage', 100)
                    ->where('is_published', VideoPublished::PUBLISHED)
                    ->simplePaginate(5)
                    ->withQueryString();

                if ($request->wantsJson()) {
                    return [
                        'comments' => $commentsWithPaginate,
                        'allVideo' => $allVideos
                    ];
                }

                return inertia('Video/Index', [
                    'video' => $findVideo,
                    'allVideo' => $allVideos,
                    'comments' => $commentsWithPaginate
                ]);
            },
            fn () => to_route('home')
        );
    }

}
