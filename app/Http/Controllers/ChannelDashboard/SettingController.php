<?php

namespace App\Http\Controllers\ChannelDashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChannelDashboard\SettingRequest;
use App\Models\Channel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;

class SettingController extends Controller
{
    public function index(Channel $channel): Response|ResponseFactory
    {
        return inertia('ChannelDashboard/Settings',[
            'channel' => $channel->withoutRelations(),
        ]);
    }

    public function update(SettingRequest $request, Channel $channel): RedirectResponse
    {
        $validatedData = $request->validated();

        if(Str::startsWith($validatedData['identifier'],'@')) {
            $validatedData['identifier'] = Str::replace('@','',$validatedData['identifier']);
        }

        if(isset($validatedData['photo'])) {
            $channel->updateChannelPhoto($validatedData['photo']);
        }

        if(isset($validatedData['cover_photo'])) {
            $channel->updateChannelCoverPhoto($validatedData['cover_photo']);
        }



        unset(
            $validatedData['photo'],
            $validatedData['cover_photo']
        );

        $channel->update($validatedData);

        return back(303);
    }
}
