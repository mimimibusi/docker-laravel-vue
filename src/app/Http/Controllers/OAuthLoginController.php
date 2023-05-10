<?php

namespace App\Http\Controllers;

use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Socialite;

class OAuthLoginController extends Controller
{
    public function __construct(
        User $user
    ){
        $this->user = $user;
    }

    public function getGoogleAuth()
    {
        return Socialite::driver('google')->redirect();
    }

    public function authGoogleCallBack()
    {
        $googleUser = Socialite::driver('google')->user();
        \Log::info($googleUser->token);
        $authUser = Auth::user();
        $authUser->access_token = $googleUser->token;
        $authUser->save();
        // $this->user->where('id', Auth::id())->update(['access_token' => $googleUser->token]);
        return redirect('/setting');
    }

    public function judgeHaveAccessToken()
    {
        if(is_null(Auth::user()->access_token)){
            \Log::info('アクセストークンはなかったよ');
            return response()->json(['result' => false]);
        }
        \Log::info('アクセストークンがあったよ');
        return response()->json(['result' => true]);
    }
}
