<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User;
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

    public function getFriends(Request $request)
    {
        return $this->user->getFriends($request->id);
    }
}
