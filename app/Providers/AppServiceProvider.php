<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider {
    public function register(): void {}
    public function boot(): void {
        if (request()->server->has('HTTP_X_FORWARDED_PROTO') || request()->header('X-Forwarded-Proto') == 'https') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
