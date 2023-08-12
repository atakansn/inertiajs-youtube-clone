<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function __invoke(Channel $channel, Request $request)
    {
        $request->dd();
    }
}
