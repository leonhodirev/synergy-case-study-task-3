<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function subscriptions()
    {
        return $this->belongsToMany(
            User::class,
            'user_subscriptions',
            'subscriber_id',
            'subscribed_to_id'
        );
    }

    public function subscribers()
    {
        return $this->belongsToMany(
            User::class,
            'user_subscriptions',
            'subscribed_to_id',
            'subscriber_id'
        );
    }

    public function postAccessRequests()
    {
        return $this->hasMany(PostAccessRequest::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
