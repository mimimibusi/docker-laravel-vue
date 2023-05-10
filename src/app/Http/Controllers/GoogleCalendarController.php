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
    )
    {
        // $this->googleCalendarServiceProvider = $googleCalendarServiceProvider;
    }

    public function getEvent(Request $request){
        $events = app('GoogleCalendarServiceProvider')->getEvents();
        \Log::info($events);
        return $events;
        // return $this->googleCalendarServiceProvider->getEvents();
    }
}
