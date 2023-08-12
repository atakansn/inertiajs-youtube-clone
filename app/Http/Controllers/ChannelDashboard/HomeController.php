<?php

namespace App\Http\Controllers\ChannelDashboard;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Models\Comment;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request, Channel $channel)
    {
        $totalSubscriptions = $channel->subscriptions()->count();
        $totalVideos = $channel->videos()->count();
        $totalComments = Comment::where('user_id', auth()->user()->getAuthIdentifier())->count();

        return inertia('ChannelDashboard/Home', [
            'totalSubscriptions' => $totalSubscriptions,
            'totalVideos' => $totalVideos,
            'totalComments' => $totalComments
        ]);
    }
}
