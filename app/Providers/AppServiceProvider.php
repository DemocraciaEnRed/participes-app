<?php

namespace App\Providers;

// use Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Blade::if('hasRole', function ($roles) {
            $user = auth()->user();
            if($user){
                return $user->hasAnyRole($roles);
            } 
            return false;
        });
        
        Blade::if('isMember', function ($objectiveId) {
            $user = auth()->user();
            if($user){
                return $user->hasRole('admin') ?: $user->isMemberObjective($objectiveId);
            } 
            return false;
        });
        Blade::if('isManager', function ($objectiveId) {
            $user = auth()->user();
            if($user){
                return  $user->hasRole('admin') ?: $user->isManagerObjective($objectiveId);
            } 
            return false;
        });
        Blade::if('isReporter', function ($objectiveId) {
            $user = auth()->user();
            if($user){
                return $user->hasRole('admin') ?: $user->isReporterObjective($objectiveId);
            } 
            return false;
        });
        Blade::if('isOnlyMember', function ($objectiveId) {
            $user = auth()->user();
            if($user){
                return $user->isMemberObjective($objectiveId);
            } 
            return false;
        });
        Blade::if('isOnlyManager', function ($objectiveId) {
            $user = auth()->user();
            if($user){
                return $user->isManagerObjective($objectiveId);
            } 
            return false;
        });
        Blade::if('isOnlyReporter', function ($objectiveId) {
            $user = auth()->user();
            if($user){
                return $user->isReporterObjective($objectiveId);
            } 
            return false;
        });

         Blade::directive('datetime', function ($expression) {
            return "<?php echo ($expression)->format('d/m/Y H:i'); ?>";
        });
         Blade::directive('justdate', function ($expression) {
            return "<?php echo ($expression)->format('d/m/Y'); ?>";
        });

    }
}
