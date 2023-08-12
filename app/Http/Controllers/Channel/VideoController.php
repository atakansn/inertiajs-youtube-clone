<?php

namespace App\Http\Controllers\Channel;

use App\Enums\VideoPublished;
use App\Http\Controllers\Controller;
use App\Models\Channel;

class VideoController extends Controller
{
    public function __invoke(Channel $identifier)
    {
        $identifier->loadCount(['subscriptions', 'videos']);
        $identifier->load('subscriptions');

        $videos = $identifier->videos()
            ->where('processing_percentage', 100)
            ->where('is_published', VideoPublished::PUBLISHED)
            ->with('channel')
            ->orderBy('created_at', 'DESC')
            ->cursorPaginate(12);

        if (\request()->wantsJson()) {
            return $videos;
        }

        return inertia('Channel/Videos', [
            'channel' => $identifier,
            'channelVideos' => $videos
        ]);
    }
}
