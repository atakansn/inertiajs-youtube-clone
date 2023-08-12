<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class Video extends Model
{
    use HasFactory, HasUlids, Searchable;

    protected $guarded = [];

    protected $appends = [
        'video_thumbnail',
        'video_url',
        'video_created_at'
    ];

    protected $withCount = [
        'comments'
    ];

    public function updateVideoThumbnail(UploadedFile $uploadedFile)
    {
        tap($this->thumbnail, function ($previous) use ($uploadedFile) {
            $this->forceFill([
                'thumbnail' => $uploadedFile->storePublicly(
                    "media/channels/channel-{$this->channel_id}/processed-videos/{$this->id}/thumbnails",
                    ['disk' => 'public']
                )
            ])->save();

            if($previous){
                Storage::disk('public')->delete($previous);
            }
        });
    }

    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title
        ];
    }

    public function searchableAs(): string
    {
        return 'videos_index';
    }

    public function videoCreatedAt(): Attribute
    {
        return Attribute::get(function () {
            return $this->created_at?->diffForHumans();
        });
    }

    public function videoThumbnail(): Attribute
    {
        return Attribute::get(function () {
            $checkUrl = Str::startsWith($this->thumbnail, [
                'https://via.placeholder.com',
                'https://images.unsplash.com',
                'https://ui-avatars.com'
            ]);

            return !$checkUrl
                ? Storage::disk('public')->url($this->thumbnail)
                : $this->thumbnail;
        });
    }

    public function videoUrl(): Attribute
    {
//        return Attribute::get(function () {
//            $replace = Str::replaceArray('storage',[''],$this->path);
//
//            return Storage::disk('public')->url("videos/{$this->id}/{$this->id}.m3u8");
//        });

        return Attribute::get(
            get: fn () => $this->processed_file_path
                ? Storage::disk('public')->url($this->processed_file_path)
                : null
        );
    }

    public function watchHistory()
    {
        return $this->hasMany(WatchHistory::class, 'video_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'video_id')
            ->whereNull('comment_id')
            ->orderBy('created_at', 'DESC');
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'voteable');
    }
}
