<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\StreamedResponse;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('test', function () {
    set_time_limit(120);

    $headers = [
        'Content-Type' => 'text/event-stream',
        'Cache-Control' => 'no-cache',
        'Connection' => 'keep-alive',
        'X-Accel-Buffering' => 'no'
    ];

    $statusCode = 200;

    return response()->stream(function () {
        $percentage = 0;
        $running = true;

        while ($running) {

            $percentage++;

            echo 'data: {"percentage": "' . $percentage . '"}';
            echo PHP_EOL . PHP_EOL;

            ob_flush();
            flush();

            if (connection_aborted()) $running = false;

            sleep(1);

            if ($percentage === 10) {
                $running = false;
            }

            if ($running === false) {
                header('Connection: close');
                exit();
            }
        }
    }, $statusCode, $headers);

});
