<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CommentController extends Controller
{
    public function store(Request $request, Video $video)
    {
        $createdComment = auth()->user()->comments()->create([
            'content' => $request->text,
            'video_id' => $video->id,
            'comment_id' => $request->comment_id
        ]);

        $createdComment->load(['user.channel', 'votes', 'replies']);

        return $createdComment;
    }

    public function update(Comment $comment, Request $request)
    {
        $comment->update([
            'content' => $request->input('content')
        ]);

        $comment->refresh();

        return back(303);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        $comment->refresh();

        return back(303);
    }
}
