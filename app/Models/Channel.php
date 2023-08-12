<?php

namespace App\Models;

use App\Traits\HasChannelPhoto;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Channel extends Model
{
    use HasFactory, HasUlids, HasChannelPhoto, Searchable;

    protected $guarded = [];

    protected $appends = [
        'channel_photo_url',
        'channel_cover_photo_url'
    ];

    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'identifier' => $this->identifier
        ];
    }

    public function searchableAs(): string
    {
        return 'channels_index';
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'channel_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'channel_id');
    }

    public function subscribers()
    {
        return $this->belongsToMany(User::class, 'subscriptions', 'channel_id', 'user_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }

}
