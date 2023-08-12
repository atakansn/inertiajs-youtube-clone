<?php

namespace App\Http\Controllers\ChannelDashboard;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoPublishedController extends Controller
{
    public function __invoke(Request $request, Video $video)
    {
        if($request->filled('is_published')) {
            $validatedData = $request->validate([
               'is_published' => 'boolean'
            ]);

            $video->update($validatedData);

            return back(303);
        }

        return response()->noContent();
    }
}
