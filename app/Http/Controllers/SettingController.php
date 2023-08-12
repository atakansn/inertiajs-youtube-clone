<?php

namespace App\Http\Controllers;

use App\Traits\HasCurrentSessions;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use HasCurrentSessions;

    public function __invoke(Request $request)
    {
        return inertia('Settings', [
            'sessions' => $this->sessions($request)->all(),
        ]);
    }
}
