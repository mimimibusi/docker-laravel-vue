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

    //ここから下いらないかも
    // 以下のメソッドはAuthenticatableインターフェースの実装に必要
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

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
