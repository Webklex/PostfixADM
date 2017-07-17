<?php

namespace App\Providers;

use App\Libraries\BrowserHistory\BrowserHistory;
use Illuminate\Support\ServiceProvider;

class BrowserHistoryProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {}

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton('BrowserHistory', function () {
            return new BrowserHistory(app(\Illuminate\Http\Request::class));
        });
    }
}
