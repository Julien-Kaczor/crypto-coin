<?php


namespace App\Providers;

use App\Kraken\Client;
use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client as HttpClient;

class KrakenServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerClient();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerClient();
    }

    protected function registerClient(): void
    {
        $this->app->singleton(Contracts\Client::class, function () {
            $config = $this->app->make('config')->get('kraken', []);

            dd("ok");
            return new Client(
                new HttpClient(),
                $config['key'] ?? null,
                $config['secret'] ?? null,
                $config['otp'] ?? null
            );
        });
    }
}
