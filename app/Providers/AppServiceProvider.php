<?php
namespace App\Providers;

use App\Services\AuditService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    // In app/Providers/AppServiceProvider.php
    public function register()
    {
        $this->app->singleton(AuditService::class, function ($app) {
            return new AuditService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
