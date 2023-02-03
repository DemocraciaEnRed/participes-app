<?php

use App\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HomepageSettings extends Migration
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
 
             // Check if setting exists
             $settingDoesExists = DB::table('settings')->where('name', 'app_home_subtitle')->count() > 0;
             // If setting doesn't exists, then create it
             if ($settingDoesExists) {
                 // update the name to be app_homepage_subtitle
                DB::table('settings')->where('name', 'app_home_subtitle')->update(['name' => 'app_homepage_subtitle']);
             }

             // Check if setting exists
             $settingDoesntExists = DB::table('settings')->where('name', 'app_homepage_show_graph_last_reports')->count() == 0;
             // If setting doesn't exists, then create it
             if ($settingDoesntExists) {
                 $setting = new Setting();
                 $setting->name = 'app_homepage_show_graph_last_reports';
                 $setting->value = true;
                 $setting->type = 'boolean';
                 $setting->cached = true;
                 $setting->save();
             }

             // Check if setting exists
             $settingDoesntExists = DB::table('settings')->where('name', 'app_homepage_show_latest_reports')->count() == 0;
             // If setting doesn't exists, then create it
             if ($settingDoesntExists) {
                 $setting = new Setting();
                 $setting->name = 'app_homepage_show_latest_reports';
                 $setting->value = true;
                 $setting->type = 'boolean';
                 $setting->cached = true;
                 $setting->save();
             }

             // Check if setting exists
             $settingDoesntExists = DB::table('settings')->where('name', 'app_homepage_latest_reports_at_the_end')->count() == 0;
             // If setting doesn't exists, then create it
             if ($settingDoesntExists) {
                 $setting = new Setting();
                 $setting->name = 'app_homepage_latest_reports_at_the_end';
                 $setting->value = false;
                 $setting->type = 'boolean';
                 $setting->cached = true;
                 $setting->save();
             }


             // Check if setting exists
             $settingDoesntExists = DB::table('settings')->where('name', 'app_homepage_show_categories_selector')->count() == 0;
             // If setting doesn't exists, then create it
             if ($settingDoesntExists) {
                 $setting = new Setting();
                 $setting->name = 'app_homepage_show_categories_selector';
                 $setting->value = true;
                 $setting->type = 'boolean';
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
        // revert the change of name app_homepage_subtitle to app_home_subtitle
        $settingExists = DB::table('settings')->where('name', 'app_homepage_subtitle')->count() > 0;
        if ($settingExists) {
            DB::table('settings')->where('name', 'app_homepage_subtitle')->update(['name' => 'app_home_subtitle']);
        }
        // check if settings exists
        $settingExists = DB::table('settings')->where('name', 'app_homepage_show_graph_last_reports')->count() > 0;
        // if settings exists, then delete it
        if ($settingExists) {
            DB::table('settings')->where('name', 'app_homepage_show_graph_last_reports')->delete();
        }
        // check if settings exists
        $settingExists = DB::table('settings')->where('name', 'app_homepage_show_latest_reports')->count() > 0;
        // if settings exists, then delete it
        if ($settingExists) {
            DB::table('settings')->where('name', 'app_homepage_show_latest_reports')->delete();
        }
        // check if settings exists
        $settingExists = DB::table('settings')->where('name', 'app_homepage_latest_reports_at_the_end')->count() > 0;
        // if settings exists, then delete it
        if ($settingExists) {
            DB::table('settings')->where('name', 'app_homepage_latest_reports_at_the_end')->delete();
        }
        // check if settings exists
        $settingExists = DB::table('settings')->where('name', 'app_homepage_show_categories_selector')->count() > 0;
        // if settings exists, then delete it
        if ($settingExists) {
            DB::table('settings')->where('name', 'app_homepage_show_categories_selector')->delete();
        }
    }
}