<?php

namespace App\Jobs;

use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class CreateVideoThumbnail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Video $video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $generateProcessedFilePath = "media/channels/channel-{$this->video->channel->id}/processed-videos/{$this->video->id}/thumbnails/{$this->video->id}.png";

        FFMpeg::fromDisk('local')
            ->open($this->video->raw_file_path)
            ->getFrameFromSeconds(2)
            ->export()
            ->save('public/' . $generateProcessedFilePath);

        $this->video->update([
            'thumbnail' => $generateProcessedFilePath
        ]);
    }
}
