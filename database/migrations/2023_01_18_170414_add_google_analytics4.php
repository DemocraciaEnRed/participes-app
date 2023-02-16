<?php

use App\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGoogleAnalytics4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         // Return true if settings table is empty
         $settingsTableIsNotEmpty = DB::table('settings')->count() > 0;

         // if settings table is not empty, then check if app_google_analytics_4_id exists
         if ($settingsTableIsNotEmpty) {
 
             // Check if app_google_analytics_4_id exists
             $googleAnalyticsIdDoesntExists = DB::table('settings')->where('name', 'app_google_analytics_4_id')->count() == 0;
 
             // If app_google_analytics_4_id doesn't exists, then create it
             if ($googleAnalyticsIdDoesntExists) {
                 $setting = new Setting();
                 $setting->name = 'app_google_analytics_4_id';
                 $setting->value = null;
                 $setting->type = 'string';
                 $setting->cached = true;
                 $setting->save();
             }
         }        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // check if app_google_analytics_4_id exists
        $googleAnalyticsIdExists = DB::table('settings')->where('name', 'app_google_analytics_4_id')->count() > 0;

        // if app_google_analytics_4_id exists, then delete it
        if ($googleAnalyticsIdExists) {
            DB::table('settings')->where('name', 'app_google_analytics_4_id')->delete();
        }
    }
}
