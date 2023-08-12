<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function __invoke(Comment $comment, Request $request)
    {
        return $comment->replies()
            ->with(['user.channel','votes'])
            ->cursorPaginate(5);
    }
}
