<?php

namespace App\Http\Controllers\ChannelDashboard;

use App\Enums\VideoPublished;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChannelDashboard\UploadRequest;
use App\Jobs\{ConvertForStreaming, CreateVideoThumbnail};
use App\Models\{Channel, Video};
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function index(Channel $channel)
    {
        return inertia('ChannelDashboard/Upload', compact('channel'));
    }

    public function store(UploadRequest $uploadRequest, Channel $channel)
    {
        $validatedData = $uploadRequest->validated();

        $video = $channel->videos()->create([
            'title' => $validatedData['videoTitle'],
            'is_published' => VideoPublished::UNPUBLISHED,
            'raw_file_path' => $validatedData['rawVideo']->store("raw-video-files")
        ]);

        CreateVideoThumbnail::dispatch($video);
        ConvertForStreaming::dispatch($video);

        return inertia('ChannelDashboard/Upload', [
            'video' => $video
        ]);
    }

    public function show(Video $video)
    {
        return $video;
    }
}
