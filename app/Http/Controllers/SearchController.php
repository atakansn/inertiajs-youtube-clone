<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request, Channel $channel)
    {
        if ($request->q === null) {
            return [];
        }

        $value = mb_substr($request->q, 0, 1);

        $channel = Channel::search($request->q)
            ->query(fn (Builder $query) => $query->where('name', 'like', "{$value}%"))
            ->query(fn (Builder $query) => $query->select(['name', 'identifier', 'id']))
            ->get();

        $video = \App\Models\Video::search($request->q)
            ->query(fn (Builder $query) => $query->where('title', 'like', "{$value}%"))
            ->query(fn (Builder $query) => $query->select(['title', 'id']))
            ->get();

        return [
            'channels' => $channel,
            'videos' => $video
        ];
    }
}
