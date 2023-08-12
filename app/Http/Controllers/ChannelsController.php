<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelsController extends Controller
{
    public function __invoke(Request $request): \Inertia\Response|\Inertia\ResponseFactory|\Illuminate\Contracts\Pagination\CursorPaginator
    {
        $channels = Channel::query()
            ->with('subscriptions')
            ->withCount('subscriptions')
            ->withCount('videos')
            ->where('user_id', '!=', auth()?->user()?->getAuthIdentifier())
            ->cursorPaginate(20);

        if ($request->wantsJson()) {
            return $channels;
        }

        return inertia('Channels', [
            'channels' => $channels
        ]);
    }
}
