<?php

namespace App\Http\Controllers;

use App\Model\User;
use Carbon\Carbon;
use Google\Service\Calendar as Calendar;
use Google_Client;
use Google_Service;
use Google_Service_Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use App\Providers\GoogleCalendarServiceProvider;
use Illuminate\Support\Facades\Log;

class GoogleCalendarController extends Controller
{
    //
    public function __construct(
        // Google_Client $googleClient
        // GoogleCalendarServiceProvider $googleCalendarServiceProvider
    )
    {
        // $this->googleClient = $googleClient;
        // $this->googleCalendarServiceProvider = $googleCalendarServiceProvider;
    }

    public function getEvent()
    {
        // $client = $this->getClient();
        // $service = new Google_Service_Calendar($client);
        // $authFilePath = storage_path('client_secret_35578369161-c1tfvcftqi12s64unt95io9s3m5pp5bg.apps.googleusercontent.com (1).json');

        
        // $this->googleClient->setAccessToken(Auth::user()->access_token);
        // $this->googleClient->addScope(Google_Service_Calendar::CALENDAR_READONLY);
        $scopes = [
            Calendar::CALENDAR,
            Calendar::CALENDAR_EVENTS,
            Calendar::CALENDAR_EVENTS_READONLY,
            Calendar::CALENDAR_READONLY,
            Calendar::CALENDAR_SETTINGS_READONLY,
        ];
        $googleClient = new Google_Client();
        $googleClient->setAuthConfig(storage_path('client_secret_35578369161-c1tfvcftqi12s64unt95io9s3m5pp5bg.apps.googleusercontent.com (1).json'));
        $googleClient->setAccessToken(Auth::user()->access_token);
        $googleClient->addScope($scopes);
        $service = new Calendar($googleClient);
        $calendarId = 'primary';
        $events = $service->events->listEvents($calendarId);
        $eventsArray = [];
        foreach($events as $key => $event){
            array_push($eventsArray, $event);
        };
        $now = Carbon::now();
        $result = array_filter($eventsArray, function($event) use ($now){
            $eventTime = new Carbon($event->start->dateTime);
            return $eventTime->gt($now);
        });
        return $result;
    }
}
