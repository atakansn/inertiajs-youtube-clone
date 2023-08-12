<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Video;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function store($entityId, $type)
    {
        $entity = $this->getEntity($entityId);

        return auth()->user()->toggleVote($entity, $type);
    }

    public function getEntity($id)
    {
        $video = Video::with(['channel','votes'])->find($id);

        if($video) return $video;

        $comment = Comment::with(['user','votes','replies'])->find($id);

        if($comment) return $comment;

        throw new ModelNotFoundException('Entity Not Found');
    }
}
