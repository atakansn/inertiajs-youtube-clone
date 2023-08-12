<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function __invoke(Channel $identifier)
    {
        $identifier->loadCount(['subscriptions', 'videos']);
        $identifier->load(['subscriptions','user']);

        return inertia('Channel/About', [
            'channel' => $identifier
        ]);
    }
}
