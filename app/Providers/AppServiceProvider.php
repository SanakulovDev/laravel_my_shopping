<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Helpers\DateHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        
        // Register a custom Blade directive for date formatting
        Blade::directive('formatDate', function ($expression) {
            return "<?php echo App\Helpers\DateHelper::format($expression); ?>";
        });
        
        Blade::directive('formatDateWithTime', function ($expression) {
            return "<?php echo App\Helpers\DateHelper::formatWithTime($expression); ?>";
        });
        
        Blade::directive('dateForHumans', function ($expression) {
            return "<?php echo App\Helpers\DateHelper::diffForHumans($expression); ?>";
        });
    }
}
