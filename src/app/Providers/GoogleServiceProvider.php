<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Google\Client;

class GoogleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('Google\Client', function () {
            $client = new Google_Cliant();
            $client->setApplicationName('Your Application Name');
            $client->setScopes(['https://www.googleapis.com/auth/calendar']);
            $client->setAuthConfig('path/to/your/client_secret.json');
            $client->setAccessType('offline');
            $client->setPrompt('select_account consent');
            // Google APIの設定を行うコードをここに記述する
            return $client;
        });
    }

    public function boot()
    {
        // ここに、サービスプロバイダの初期化処理を記述する
    }
}
