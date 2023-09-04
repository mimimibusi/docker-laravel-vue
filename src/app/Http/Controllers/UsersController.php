<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    //
    public function __construct(
        User $user 
    )
    {
        $this->user = $user;
    }
    
    public function getData()
    {
        return Auth::user();
    }

    public function getFriends()
    {
        $id = Auth::id();
        $friends = $this->user->getFriends($id);
        $result = $friends->map(function($friend){
            return [
                'id' => $friend->id,
                'name' => $friend->name
            ];
        });
        return $result;
    }
}
