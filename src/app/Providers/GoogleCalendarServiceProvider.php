<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class GoogleCalendarServiceProvider extends ServiceProvider
{
    // ...
    public function register()
    {
        $this->app->bind('Google_Calendar', function ($app) {
            $client = new \Google\Client();
            // 以下のように、Google API の設定を行います。
            $client->setApplicationName('Line Schedule Management');
            $client->setScopes([\Google_Service_Calendar::CALENDAR_READONLY]);
            $client->setAuthConfig('../../config/json/client_secret_35578369161-c1tfvcftqi12s64unt95io9s3m5pp5bg.apps.googleusercontent.com.json');
            $client->setAccessType('offline');
            $client->setPrompt('select_account consent');

            return new \Google_Service_Calendar($client);
        });
    }

    public function getEvents()
    {
        $client = app('Google_Calendar');
        $service = new \Google_Service_Calendar($client);
        $calendarId = 'primary';
        $optParams = [
            'maxResults' => 10,
            'orderBy' => 'startTime',
            'singleEvents' => true,
            'timeMin' => date('c'),
        ];
        $results = $service->events->listEvents($calendarId, $optParams);
        $events = $results->getItems();
        return $events;
    }

}
