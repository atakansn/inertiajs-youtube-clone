<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class ReplyUpdate extends Controller
{
    public function __invoke(Comment $commentId, Request $request)
    {
        $commentId->update([
            'content' => $request->input('content')
        ]);

        $commentId->refresh();

        return back(303);
    }
}
