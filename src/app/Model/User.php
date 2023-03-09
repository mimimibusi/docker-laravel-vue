<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function getData(int $id)
    {
        $user = self::find($id);
        return $user;
    }
    public function getFriends(int $id)
    {
        $friends = self::where('id', '!=', $id)->get();
        return $friends;
    }
}
