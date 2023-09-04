<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class User extends Model implements AuthenticatableContract

{
    use Authenticatable;

    protected $fillable = [
        'name', 'email', 'password', 'google_oauth',
    ];

    public function chatRooms(): BelongsToMany
    {
        return $this->belongsToMany(ChatRoom::class)->withTimestamps();
    }

    public function getFriends(int $id)
    {
        $friends = self::where('id', '!=', $id)->get();
        return $friends;
    }
}
