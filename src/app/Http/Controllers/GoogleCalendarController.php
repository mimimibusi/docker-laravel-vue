<?php

namespace App\Http\Controllers;

use App\Model\User;
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

    public function index()
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
        \Log::info(Google_Service_Calendar::CALENDAR_READONLY);
        $service = new Calendar($googleClient);
        $calendarId = 'primary';
        $events = $service->events->listEvents($calendarId);
        // \Log::info(print_r($events));
        return 'aa';
    }

    public function getEvent(Request $request)
    {
        $events = app('GoogleCalendarServiceProvider')->getEvents();
        \Log::info($events);
        return $events;
        // return $this->googleCalendarServiceProvider->getEvents();
    }
}
