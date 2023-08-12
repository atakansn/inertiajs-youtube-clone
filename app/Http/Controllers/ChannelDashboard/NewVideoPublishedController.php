<?php

namespace App\Http\Controllers\ChannelDashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChannelDashboard\NewVideoPublishedRequest;
use App\Models\Video;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JetBrains\PhpStorm\NoReturn;

class NewVideoPublishedController extends Controller
{
    public function __invoke(NewVideoPublishedRequest $request, Video $video): RedirectResponse
    {
        $validatedData = $request->validated();

        $video->update($validatedData);

        return back(303);
    }
}
