<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HasChannelPhoto
{

    use HasColors;

    private array $channelPhotoPaths = [
        'photo' => 'channel-photo',
        'cover_photo' => 'channel-cover-photo'
    ];

    public function deleteChannelPhoto()
    {
        if (is_null($this->photo)) {
            return;
        }

        $photo = Str::startsWith($this->photo, 'https://ui-avatars.com');

        if ($photo) {
            return;
        }

        Storage::disk('public')->delete($this->photo);

        $this->forceFill([
            'photo' => $this->avatar($this->name)
        ])->save();
    }

    public function avatarChangeColor()
    {
        return $this->update([
            'photo' => $this->avatar($this->name)
        ]);
    }

    public function channelPhotoUrl(): Attribute
    {
        return Attribute::get(function () {

            $photo = Str::startsWith($this->photo, 'https://ui-avatars.com');

            return !$photo
                ? Storage::disk('public')->url($this->photo)
                : $this->photo;
        });
    }

    public function channelCoverPhotoUrl(): Attribute
    {
        return Attribute::get(function () {

            $photo = Str::startsWith($this->cover_photo, 'https://images.unsplash.com');

            return !$photo
                ? Storage::disk('public')->url($this->cover_photo)
                : $this->cover_photo;
        });
    }

    public function updateChannelPhoto(UploadedFile $uploadedFile)
    {
        tap($this->photo, function ($previous) use ($uploadedFile) {
            $fileName = $uploadedFile->storePublicly(
                "media/channels/channel-{$this->id}",
                ['disk' => 'public']
            );

            $this->forceFill([
                'photo' => $fileName
            ])->save();

            if ($previous) {
                Storage::disk('public')->delete($previous);
            }

        });
    }

    public function updateChannelCoverPhoto(UploadedFile $uploadedFile)
    {
        tap($this->cover_photo, function ($previous) use ($uploadedFile) {
            $this->forceFill([
                'cover_photo' => $uploadedFile->storePublicly(
                    "media/channels/channel-{$this->id}",
                    ['disk' => 'public']
                )
            ])->save();

            if ($previous) {
                Storage::disk('public')->delete($previous);
            }

        });

    }
}
