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
        $optParams = array(
            'orderBy' => 'startTime',
            'singleEvents' => true,
            'timeMin' => Carbon::now()->toIso8601String()
        );
        try{
            $events = $service->events->listEvents($calendarId, $optParams);
            $result = [];
            while(true) {
                foreach ($events->getItems() as $event) {
                    if ($event->start and $event->end) {
                        $result[] = [
                            'id' => $event->id,
                            'summary' => $event->getSummary(),
                            'start' => $event->start->dateTime,
                            'end' => $event->end->dateTime
                        ];
                    }
                }
                $pageToken = $events->getNextPageToken();
                \Log::info($pageToken);
                if ($pageToken) {
                    $optParams = array('pageToken' => $pageToken);
                    $events = $service->events->listEvents('primary', $optParams);
                } else {
                    break;
                }
            }
        return $result;
        } catch (\Google\Service\Exception $e){
            $errorMesasge = $e->getMessage();
            \Log::info($errorMesasge);
        }
    }
}
