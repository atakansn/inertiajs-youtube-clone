<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUlids;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function channel()
    {
        return $this->hasOne(Channel::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function subscribers()
    {
        return $this->belongsToMany(Channel::class, 'subscriptions');
    }

    public function toggleVote($entity, $type)
    {
        $userVote = $entity->votes->where('user_id',$this->id)->first();

        if($userVote){
            $userVote->update([
                'type' => $type
            ]);

            return $userVote->refresh();
        }

        return $entity->votes()->create([
            'type' => $type,
            'user_id' => $this->id
        ]);
    }
}
