<?php

namespace App\Http\Controllers\ChannelDashboard;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Channel $channel, Authenticatable $authenticatable)
    {
        $data = $authenticatable->subscribers()->with('subscriptions')->simplePaginate(20);

        if(\request()->wantsJson()){
            return $data;
        }

        return inertia('ChannelDashboard/Subscriptions',[
            'subscriptions' => $data
        ]);
    }
}
