<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Actions\ConfirmPassword;

class OtherBrowserLogoutController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function __invoke(Request $request, StatefulGuard $statefulGuard)
    {
        $confirmed = app(ConfirmPassword::class)($statefulGuard, $request->user(), $request->password);

        if (!$confirmed) {
            throw ValidationException::withMessages([
               'password' => __('Girdiğiniz parola yanlış.')
            ]);
        }

        //$statefulGuard->logoutOtherDevices($request->password);
        Auth::logoutOtherDevices($request->password);

        $this->deleteOtherSessions($request);

        return back(303);
    }

    protected function deleteOtherSessions(Request $request)
    {
        if(config('session.driver') !== 'database'){
            return;
        }

        DB::table('sessions')
            ->where('user_id', $request->user()->getAuthIdentifier())
            ->where('id','!=',$request->session()->getId())
            ->delete();
    }
}
