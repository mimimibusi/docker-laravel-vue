<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;


class User extends Model implements AuthenticatableContract

{
    use Authenticatable;

    protected $fillable = [
        'name', 'email', 'password'
    ];

    public function getFriends(int $id)
    {
        $friends = self::where('id', '!=', $id)->get();
        return $friends;
    }
}
