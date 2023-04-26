<?php

namespace App\Http\Controllers;

use App\Model\User;
use Illuminate\Http\Request;
// use App\Providers\GoogleCalendarServiceProvider;
use Illuminate\Support\Facades\Log;

class GoogleCalendarController extends Controller
{
    //
    public function __construct(
        // GoogleCalendarServiceProvider $googleCalendarServiceProvider
        User $user
    )
    {
        // $this->googleCalendarServiceProvider = $googleCalendarServiceProvider;
        $this->user = $user;
    }
    
    public function getEvent(Request $request){
        $events = app('GoogleCalendarServiceProvider')->getEvents();
        \Log::info($events);
        return $events;
        // return $this->googleCalendarServiceProvider->getEvents();
    }

    public function saveAccessToken(Request $request){
        $this->user->where('id', 4)->update(['access_token' => $request->accessToken]);
    }
}
