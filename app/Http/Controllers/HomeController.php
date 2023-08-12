<?php

namespace App\Http\Controllers;

use App\Enums\VideoPublished;
use App\Models\Video;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        $videos = Video::with('channel')
            ->where('processing_percentage',100)
            ->where('is_published', VideoPublished::PUBLISHED)
            ->orderBy('created_at','DESC')
            ->cursorPaginate(20);

        if(\request()->wantsJson()){
            return $videos;
        }

        return inertia('Home',[
            'videos' => $videos
        ]);
    }
}
