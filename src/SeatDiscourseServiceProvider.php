<?php

namespace Goemktg\Seat\SeatDiscourse;

use Goemktg\Seat\SeatDiscourse\Commands\SyncRolesWithDiscourse;
use Seat\Services\AbstractSeatPlugin;

//use Goemktg\Seat\SeatDiscourse\Observers\RefreshTokenObserver;
//use Seat\Eveapi\Models\RefreshToken;

class SeatDiscourseServiceProvider extends AbstractSeatPlugin
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->addRoutes();
        $this->addViews();
        //$this->addCommands();

        //RefreshToken::observe(RefreshTokenObserver::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/seatdiscourse.config.php', 'seatdiscourse.config');
        $this->mergeConfigFrom(__DIR__ . '/config/seatdiscourse.sidebar.php', 'package.sidebar');
    }

    private function addCommands()
    {

        $this->commands([
            SyncRolesWithDiscourse::class,
        ]);

    }

    private function addViews()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'seatdiscourse');
    }

    private function addRoutes()
    {
        if (! $this->app->routesAreCached()) {
            include __DIR__ . '/Http/routes.php';
        }
    }

    /**
     * Return the plugin public name as it should be displayed into settings.
     *
     * @example SeAT Web
     *
     * @return string
     */
    public function getName(): string
    {
        return 'SeAT-Discourse';
    }

    /**
     * Return the plugin repository address.
     *
     * @example https://github.com/eveseat/web
     *
     * @return string
     */
    public function getPackageRepositoryUrl(): string
    {
        return 'https://github.com/goemktg/seat-discourse';
    }

    /**
     * Return the plugin technical name as published on package manager.
     *
     * @example web
     *
     * @return string
     */
    public function getPackagistPackageName(): string
    {
        return 'seat-discourse';
    }

    /**
     * Return the plugin vendor tag as published on package manager.
     *
     * @example eveseat
     *
     * @return string
     */
    public function getPackagistVendorName(): string
    {
        return 'goemktg';
    }
}
