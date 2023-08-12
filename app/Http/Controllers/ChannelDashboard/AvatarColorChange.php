<?php

namespace App\Http\Controllers\ChannelDashboard;

use App\Http\Controllers\Controller;
use App\Models\Channel;

class AvatarColorChange extends Controller
{
    public function __invoke(Channel $channel)
    {
        $channel->avatarChangeColor();
    }
}
