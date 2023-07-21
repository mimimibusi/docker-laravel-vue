<?php

namespace App\Http\Controllers;

use App\Model\User;
use Carbon\Carbon;
use Google_Client;
use Google_Service;
use Google_Service_Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use App\Providers\GoogleCalendarServiceProvider;
use Illuminate\Support\Facades\Log;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;

class GoogleCalendarController extends Controller
{
    //
    public function __construct(
        Google_Client $googleClient
        // GoogleCalendarServiceProvider $googleCalendarServiceProvider
    )
    {
        $this->googleClient = $googleClient;
        // $this->googleCalendarServiceProvider = $googleCalendarServiceProvider;
    }

    public function getEvent(Request $request)
    {
        $scopes = [
            Google_Service_Calendar::CALENDAR,
            Google_Service_Calendar::CALENDAR_EVENTS,
            Google_Service_Calendar::CALENDAR_EVENTS_READONLY,
            Google_Service_Calendar::CALENDAR_READONLY,
            Google_Service_Calendar::CALENDAR_SETTINGS_READONLY,
        ];
        // $this->googleClient->setAuthConfig(storage_path('client_secret_35578369161-c1tfvcftqi12s64unt95io9s3m5pp5bg.apps.googleusercontent.com (1).json'));
        $this->googleClient->setAccessToken(Auth::user()->access_token);
        $service = new Google_Service_Calendar($this->googleClient);
        $optParams = array(
            'orderBy' => 'startTime',
            'singleEvents' => true,
            'timeMin' => Carbon::parse($request->currentMonth)->startOfMonth()->format(DATE_RFC3339),
            'timeMax' => Carbon::parse($request->currentMonth)->endOfMonth()->format(DATE_RFC3339)
        );
        try{
            // $events = $service->calendarList->listCalendarList();
            $events = $service->events->listEvents('primary', $optParams);
            // \Log::info(print_r($events, true));
            $result = [];
            while(true) {
                foreach ($events->getItems() as $event) {
                    if ($event->start->dateTime and $event->end->dateTime) {
                        $result[] = [
                            'id' => $event->id,
                            'summary' => $event->getSummary(),
                            'start' => $event->start->dateTime,
                            'end' => $event->end->dateTime,
                            'colorId' => $event->colorId,
                            'calendarId' => $event->getOrganizer()->getEmail(),
                        ];
                    }else {
                        $result[] = [
                            'id' => $event->id,
                            'summary' => $event->getSummary(),
                            'start' => $event->start->date,
                            'end' => $event->end->date,
                            'colorId' => $event->colorId,
                            'calendarId' => $event->getOrganizer()->getEmail(),
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
            \Log::info($result);
            return $result;
        } catch (\Google\Service\Exception $e){
            $errorMesasge = $e->getMessage();
            \Log::info($errorMesasge);
        }
    }

    public function createEvent(Request $request)
    {
        \Log::info($request);
        $event = new Google_Service_Calendar_Event([
            'summary' => $request->summary,
            'start' => [
                'dateTime' => Carbon::parse($request['start'])
            ],
            'end' => [
                'dateTime' => Carbon::parse($request['end'])
            ]
        ]);
        $service = new Google_Service_Calendar($this->googleClient);
        $this->googleClient->setAccessToken(Auth::user()->access_token);
        $newEvent = $service->events->insert('primary', $event);
        $result = [
            'id' => $newEvent->id,
            'summary' => $newEvent->getSummary(),
            'start' => $newEvent->start->dateTime,
            'end' => $newEvent->end->dateTime,
            'colorId' => $newEvent->colorId,
            'calendarId' => $newEvent->getOrganizer()->getEmail(),
        ];
        return $result;
    }
}
