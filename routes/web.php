<?php

use App\Http\Controllers\ReplyUpdate;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Channel\{AboutController,
    ReplyController,
    VideoController
};
use App\Http\Controllers\ChannelDashboard\{AvatarColorChange,
    ChannelPhotoDelete,
    HomeController,
    NewVideoPublishedController,
    SettingController,
    SubscriptionController,
    UploadController,
    VideoPublishedController
};
use App\Http\Controllers\ChannelsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\OtherBrowserLogoutController;
use App\Http\Controllers\VideoViewController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\WatchHistoryController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;

/** GUEST ROUTES */
Route::middleware('guest')
    ->group(function () {
    Route::get('/login', fn () => inertia('Auth/Login'))->name('login');
    Route::get('/register', fn () => inertia('Auth/Register'))->name('register');

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->middleware(['guest:' . config('fortify.guard')])
        ->name('password.request');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->middleware(['guest:' . config('fortify.guard')])
        ->name('password.reset');

});

Route::get('/', \App\Http\Controllers\HomeController::class)->name('home');
Route::name('channel.')->group(function () {
    Route::get('@{identifier:identifier}/videos', VideoController::class)
        ->name('videos')
        ->where('identifier', '[A-Za-z0-9\-\_]+');

    Route::get('@{identifier:identifier}/about', AboutController::class)
        ->name('about')
        ->where('identifier', '[A-Za-z0-9\-\_]+');
});
Route::get('/view', VideoViewController::class)->name('view');
Route::get('channels', ChannelsController::class)->name('channels');
Route::get('comments/{comment}/replies', ReplyController::class)->name('replies.show');
Route::get('search', SearchController::class);

/** AUTH ROUTES **/
Route::middleware('auth')->group(function () {

    Route::prefix('settings')
        ->name('settings.')
        ->group(function () {
        Route::get('/', \App\Http\Controllers\SettingController::class)->name('index');
        Route::delete('other-browser-sessions', OtherBrowserLogoutController::class)->name('other-browser-sessions.destroy');
    });

    Route::prefix('channel-dashboard')
        ->name('channel-dashboard.')
        ->group(function () {
        Route::get('{channel}/', HomeController::class)->name('index');
        Route::get('{channel}/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('{channel}/settings', [SettingController::class, 'update'])->name('settings.update');
        Route::get('{channel}/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
        Route::put('{video}/new-video-published', NewVideoPublishedController::class)->name('new-video-published');
        Route::patch('{video}/video-published', VideoPublishedController::class)->name('video.published');

        Route::controller(\App\Http\Controllers\ChannelDashboard\VideoController::class)
            ->group(function () {
            Route::get('{channel}/videos', 'index')->name('videos.index');
            Route::get('video/{video}/edit', 'edit')->name('videos.edit');
            Route::put('video/{video}', 'update')->name('videos.update');
            Route::delete('{channel}/videos', 'destroy')->name('videos.destroy');
        });

        Route::controller(UploadController::class)
            ->group(function () {
            Route::get('{channel}/upload', 'index')->name('video.upload.index');
            Route::get('{video}/feedback', 'show')->name('video.upload.show');
            Route::post('{channel}/upload', 'store')->name('video.upload.store');
        });
    });

    Route::controller(\App\Http\Controllers\SubscriptionController::class)
        ->name('subscription.')
        ->group(function () {
        Route::post('channels/{channel}/subscriptions', 'store')->name('store');
        Route::delete('channels/{channel}/subscriptions/{subscription}', 'destroy')->name('destroy');
    });

    Route::controller(CommentController::class)
        ->name('comments.')
        ->group(function () {
        Route::post('videos/{video}/comments', 'store')->name('store');
        Route::patch('videos/{comment}/edit', 'update')->name('update');
        Route::delete('videos/{comment}/destroy', 'destroy')->name('destroy');
    });

    Route::post('votes/{entityId}/{type}', [VoteController::class, 'store'])->name('votes.store');
    Route::put('videos/{video}/watch', WatchHistoryController::class)->name('watch.history.update');
    Route::put('{channel}/avatar-color-change', AvatarColorChange::class)->name('avatar-color-change');
    Route::patch('video/{commentId}/update', ReplyUpdate::class)->name('reply.update');
    Route::delete('{channel}/photo-delete', ChannelPhotoDelete::class)->name('channel-photo-delete');

});


