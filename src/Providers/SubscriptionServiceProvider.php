<?php

namespace Chelsymooy\Subscriptions\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

use Chelsymooy\Subscriptions\Models\Plan;
use Chelsymooy\Subscriptions\Models\PlanPrice;
use Chelsymooy\Subscriptions\Models\Subscription;
use Chelsymooy\Subscriptions\Models\Bill;

use Illuminate\Console\Scheduling\Schedule;
use Chelsymooy\Subscriptions\Console\Commands\RecurringBill;

class SubscriptionServiceProvider extends ServiceProvider {

    protected $namespace = 'Chelsymooy\Subscriptions\Http\Controllers';

    public const HOME = '/subs/login';

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //REGISTER COMMAND
        $this->commands([
            RecurringBill::class,
        ]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        // REGISTER CONFIG
        $this->publishes([
            __DIR__.'/../../config/subscription.php' => config_path('subscription.php'),
        ]);

        // REGISTER MIGRATION
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        // REGISTER OBSERVER
        \Chelsymooy\Subscriptions\Models\Bill::observe(new \Chelsymooy\Subscriptions\Observers\BillGeneratingNo);
        \Chelsymooy\Subscriptions\Models\Bill::observe(new \Chelsymooy\Subscriptions\Observers\ExtendSubscription);
        
        // REGISTER CONSOLE
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('subscriptions:recurring')->dailyAt('01:00');
        });

        // REGISTER MIDDLEWARE
        
        // REGISTER ROUTES
        $this->mapApiRoutes();
        $this->mapWebRoutes();

        // REGISTER VIEWS
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'subs');
        $this->publishes([
            __DIR__.'/../../resources/assets' => public_path('subs'),
        ]);

        //REGISTER EMAIL FUNCTION
        //REQUIRE: ICHIKAWA SENDGRID & BARRYVDH PDF
        // \Chelsymooy\Subscriptions\Models\Bill::observe(new \Chelsymooy\Subscriptions\Observers\SubscribeEmailNotification);

    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        // REGISTER ROUTES
        Route::middleware('web')
            ->namespace($this->namespace)
            ->prefix('/subs')
            ->group(__DIR__.'/../../routes/web.php');
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::middleware('api')
            ->namespace($this->namespace)
            ->prefix('api/subs')
            ->group(__DIR__.'/../../routes/api.php');
    }
}
