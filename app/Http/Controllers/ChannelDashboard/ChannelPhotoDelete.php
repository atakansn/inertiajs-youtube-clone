<?php

namespace App\Http\Controllers\ChannelDashboard;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelPhotoDelete extends Controller
{
    public function __invoke(Channel $channel)
    {
        $channel->deleteChannelPhoto();
    }
}
