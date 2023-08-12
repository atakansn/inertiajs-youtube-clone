<?php

namespace App\Jobs;

use App\Models\Video;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\MediaOpener;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class ConvertForStreaming implements ShouldQueue
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
    public function handle()
    {
        $generateProcessedFilePath = "media/channels/channel-{$this->video->channel->id}/processed-videos/{$this->video->id}/{$this->video->id}.m3u8";

        $lowBitrate = (new X264)->setKiloBitrate(500);
        $midBitrate = (new X264)->setKiloBitrate(1500);
        $highBitrate = (new X264)->setKiloBitrate(3000);

        FFMpeg::fromDisk('local')
            ->open($this->video->raw_file_path)
            ->exportForHLS()
            ->onProgress(function ($percentage) {
                $this->video->update([
                    'processing_percentage' => $percentage
                ]);
            })
            ->addFormat($lowBitrate)
            ->addFormat($midBitrate)
            ->addFormat($highBitrate)
            ->save('public/' . $generateProcessedFilePath);

        $durationInSeconds = FFMpeg::fromDisk('local')
            ->open($this->video->raw_file_path)
            ->getDurationInSeconds();

        $this->video->update([
            'duration' => $durationInSeconds,
            'processed_file_path' => $generateProcessedFilePath
        ]);
    }

}
