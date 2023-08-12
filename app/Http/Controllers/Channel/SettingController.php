<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    public function index()
    {
        return inertia('Settings');
    }

    public function update(Request $request, Channel $channel)
    {
        if(isset($request->photo)){
            $channel->updateChannelPhoto($request->photo);
        }

        $channel->update([
            'name' => $request->name,
            'identifier' => $request->identifier,
            'description' => $request->description,
        ]);

        return back(303);
    }
}
