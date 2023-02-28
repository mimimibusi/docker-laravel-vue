<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function getData(int $id)
    {
        $users = self::find($id);
        return $users;
    }
}
