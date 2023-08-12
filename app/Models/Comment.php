<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory, HasUlids;

    protected $guarded = [];

    protected $appends = [
      'comment_created_at'
    ];

    protected static function booted()
    {
        static::deleting(function ($comment){
            $comment->replies()->delete();
        });
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'comment_id', 'id')
            ->whereNotNull('comment_id')
            ->orderBy('created_at', 'DESC');
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'voteable');
    }

    public function commentCreatedAt(): Attribute
    {
        return Attribute::get(fn() => $this->created_at->diffForHumans());
    }
}
