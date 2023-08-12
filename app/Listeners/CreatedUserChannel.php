<?php

namespace App\Listeners;

use App\Traits\HasColors;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;

class CreatedUserChannel
{
    use HasColors;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $user = $event->user;

        $event->user->channel()->create([
            'user_id' => $user->id,
            'identifier' => Str::slug($user->name) . Str::random(3),
            'name' => Str::upper($user->name . Str::random(5)),
            'cover_photo' => $this->channelCoverPhoto(),
            'photo' => $this->channelPhoto($user->name)
        ]);
    }

    private function channelPhoto(string $name): string
    {
        return $this->avatar($name);
    }

    private function channelCoverPhoto(): string
    {
        return 'https://images.unsplash.com/photo-1550293038-06c7e135fcc8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1171&q=80';
    }
}
