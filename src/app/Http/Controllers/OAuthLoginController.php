<?php

namespace App\Http\Controllers;

use App\Model\User;
use Google_Client;
use Google\Service\Calendar;
use Google_Service_Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Socialite;

class OAuthLoginController extends Controller
{
    public function __construct(
        User $user,
        Google_Client $client
    ){
        $this->user = $user;
        $this->client = $client;
    }

    public function getGoogleAuth()
    {
        $scopes = [
            Google_Service_Calendar::CALENDAR,
            Google_Service_Calendar::CALENDAR_EVENTS,
            Google_Service_Calendar::CALENDAR_EVENTS_READONLY,
            Google_Service_Calendar::CALENDAR_READONLY,
            Google_Service_Calendar::CALENDAR_SETTINGS_READONLY,
        ];
        // $client = new Google_Client();
        // $this->client->setAccessType('offline');  //オフライン時にアクセストークンを更新
        // $this->client->setApprovalPrompt("force"); //承認プロンプトの動作（force: 承認UIを強制的に表示する）       
        // $this->client->setScopes(\Google_Service_Calendar::CALENDAR_READONLY); //スコープの設定        
        // $this->client->setAuthConfig(storage_path('client_secret_35578369161-c1tfvcftqi12s64unt95io9s3m5pp5bg.apps.googleusercontent.com (1).json'));

        // $auth_url = $this->client->createAuthUrl();
        // \Log::info($auth_url);
        // return Redirect::to($auth_url)->send();
        
        return Socialite::driver('google')->scopes($scopes)->redirect();
    }

    public function authGoogleCallBack(Request $request)
    {
        // \Log::info($request);
        // $data = $this->client->fetchAccessTokenWithAuthCode($request->input('code'));   
        // \Log::info($data);
        // $this->client->setAccessToken(json_encode($data));  //アクセストークンはJSONで設定
        // $refresh_token = $data['refresh_token'];
        // \Log::info($data);
        // \Log::info($refresh_token);

        // //DBに取得したトークンを保存
        // $user_model = Auth::user();
        // $user_model->fill([
        //     'access_token' => $data,
        //     'refresh_token' => $refresh_token,
        // ])->save();

        $googleUser = Socialite::driver('google')->user();
        $authUser = Auth::user();
        $authUser->access_token = $googleUser->token;
        // $authUser->refresh_token = $googleUser->refreshToken;
        $authUser->save();
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
