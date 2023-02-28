<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User;
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
    
    public function index(Request $request){
        return $this->user::all();
    }
}
