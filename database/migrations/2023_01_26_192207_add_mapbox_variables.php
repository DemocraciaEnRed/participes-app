<?php

use App\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMapboxVariables extends Migration
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
 
             // Check if app_map_enabled exists
             $enableMapDoesntExists = DB::table('settings')->where('name', 'app_map_enabled')->count() == 0;
 
             // If app_map_enabled doesn't exists, then create it
             if ($enableMapDoesntExists) {
                 $setting = new Setting();
                 $setting->name = 'app_map_enabled';
                 $setting->value = true;
                 $setting->type = 'boolean';
                 $setting->cached = true;
                 $setting->save();
             }

             // Check if app_homepage_show_map exists
             $homepageShowMapDoesntExists = DB::table('settings')->where('name', 'app_homepage_show_map')->count() == 0;
 
             // If app_homepage_show_map doesn't exists, then create it
             if ($homepageShowMapDoesntExists) {
                 $setting = new Setting();
                 $setting->name = 'app_homepage_show_map';
                 $setting->value = true;
                 $setting->type = 'boolean';
                 $setting->cached = true;
                 $setting->save();
             }

             // Check if app_mapbox_api_key exists
             $mapboxApiKeyDoesntExists = DB::table('settings')->where('name', 'app_mapbox_api_key')->count() == 0;
 
             // If app_mapbox_api_key doesn't exists, then create it
             if ($mapboxApiKeyDoesntExists) {
                 $setting = new Setting();
                 $setting->name = 'app_mapbox_api_key';
                 $setting->value = null;
                 $setting->type = 'string';
                 $setting->cached = true;
                 $setting->save();
             }

             // Check if app_mapbox_style exists
             $mapboxStyleDoesntExists = DB::table('settings')->where('name', 'app_mapbox_style')->count() == 0;
 
             // If app_mapbox_style doesn't exists, then create it
             if ($mapboxStyleDoesntExists) {
                 $setting = new Setting();
                 $setting->name = 'app_mapbox_style';
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
        
        // check if app_map_enabled exists
        $enableMapExists = DB::table('settings')->where('name', 'app_map_enabled')->count() > 0;
        // if app_map_enabled exists, then delete it
        if ($enableMapExists) {
            DB::table('settings')->where('name', 'app_map_enabled')->delete();
        }

        // check if app_homepage_show_map exists
        $homepageShowMapExists = DB::table('settings')->where('name', 'app_homepage_show_map')->count() > 0;
        // if app_homepage_show_map exists, then delete it
        if ($homepageShowMapExists) {
            DB::table('settings')->where('name', 'app_homepage_show_map')->delete();
        }

        // check if app_mapbox_api_key exists
        $mapboxApiKeyExists = DB::table('settings')->where('name', 'app_mapbox_api_key')->count() > 0;
        // if app_mapbox_api_key exists, then delete it
        if ($mapboxApiKeyExists) {
            DB::table('settings')->where('name', 'app_mapbox_api_key')->delete();
        }

        // check if app_mapbox_style exists
        $mapboxStyleExists = DB::table('settings')->where('name', 'app_mapbox_style')->count() > 0;
        // if app_mapbox_style exists, then delete it
        if ($mapboxStyleExists) {
            DB::table('settings')->where('name', 'app_mapbox_style')->delete();
        }
        
    }
}
