<?php

namespace Database\Seeders;

use App\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = new Setting();
        $setting->name = 'app_logo_color';
        $setting->value = null;
        $setting->type = 'string';
        $setting->cached = true;
        $setting->save();
        $setting = new Setting();
        $setting->name = 'app_logo_white';
        $setting->value = null;
        $setting->type = 'string';
        $setting->cached = true;
        $setting->save();
        $setting = new Setting();
        $setting->name = 'app_logo_footer';
        $setting->value = null;
        $setting->type = 'string';
        $setting->cached = true;
        $setting->save();
        $setting = new Setting();
        $setting->name = 'app_favicon';
        $setting->value = null;
        $setting->type = 'string';
        $setting->cached = true;
        $setting->save();
        $setting = new Setting();
        $setting->name = 'app_map_lat_default';
        $setting->value = -36.13810;
        $setting->type = 'float';
        $setting->cached = true;
        $setting->save();
        $setting = new Setting();
        $setting->name = 'app_map_long_default';
        $setting->value = -63.67392;
        $setting->type = 'float';
        $setting->cached = true;
        $setting->save();
        $setting = new Setting();
        $setting->name = 'app_map_zoom_default';
        $setting->value = 4;
        $setting->type = 'float';
        $setting->cached = true;
        $setting->save();
        $setting = new Setting();
        $setting->name = 'app_homepage_subtitle';
        $setting->value = 'Canal de monitoreo ciudadano, para hacer seguimiento de objetivos y metas de gobierno';
        $setting->type = 'string';
        $setting->cached = true;
        $setting->save();
        $setting = new Setting();
        $setting->name = 'app_footer_contact_info';
        $setting->value = "correo@correo.com\nCiudad Autónoma de Buenos Aires\n1423\n+54 9 01100210515";
        $setting->type = 'string';
        $setting->cached = true;
        $setting->save();
        $setting = new Setting();
        $setting->name = 'app_footer_description';
        $setting->value = 'Plataforma de monitoreo ciudadano que te permite hacer seguimiento de objetivos y metas de gobiernos';
        $setting->type = 'string';
        $setting->cached = true;
        $setting->save();
        $setting = new Setting();
        $setting->name = 'app_social_title';
        $setting->value = 'Partícipes - Monitoreo Ciudadano';
        $setting->type = 'string';
        $setting->cached = true;
        $setting->save();
        $setting = new Setting();
        $setting->name = 'app_social_description';
        $setting->value = 'Canal de monitoreo ciudadano, para hacer seguimiento de objetivos y metas de gobierno';
        $setting->type = 'string';
        $setting->cached = true;
        $setting->save();
        $setting = new Setting();
        $setting->name = 'app_social_image';
        $setting->value = null;
        $setting->type = 'string';
        $setting->cached = true;
        $setting->save();
        // migration 2023_01_18_170414_add_google_analytics4
        $setting = new Setting();
        $setting->name = 'app_google_analytics_4_id';
        $setting->value = null;
        $setting->type = 'string';
        $setting->cached = true;
        $setting->save();
        // migration 2023_01_26_192207_add_mapbox_variables
        $setting = new Setting();
        $setting->name = 'app_map_enabled';
        $setting->value = 'true';
        $setting->type = 'boolean';
        $setting->cached = true;
        $setting->save();
        $setting = new Setting();
        $setting->name = 'app_homepage_show_map';
        $setting->value = 'true';
        $setting->type = 'boolean';
        $setting->cached = true;
        $setting->save();
        $setting = new Setting();
        $setting->name = 'app_mapbox_api_key';
        $setting->value = null;
        $setting->type = 'string';
        $setting->cached = true;
        $setting->save();
        $setting = new Setting();
        $setting->name = 'app_mapbox_style';
        $setting->value = null;
        $setting->type = 'string';
        $setting->cached = true;
        $setting->save();
        // migration 2023_01_31_105115_homepage-settings
        $setting = new Setting();
        $setting->name = 'app_homepage_show_graph_last_reports';
        $setting->value = true;
        $setting->type = 'boolean';
        $setting->cached = true;
        $setting->save();
        $setting = new Setting();
        $setting->name = 'app_homepage_show_latest_reports';
        $setting->value = true;
        $setting->type = 'boolean';
        $setting->cached = true;
        $setting->save();
        $setting = new Setting();
        $setting->name = 'app_homepage_latest_reports_at_the_end';
        $setting->value = false;
        $setting->type = 'boolean';
        $setting->cached = true;
        $setting->save();
        $setting = new Setting();
        $setting->name = 'app_homepage_show_categories_selector';
        $setting->value = true;
        $setting->type = 'boolean';
        $setting->cached = true;
        $setting->save();
    }
}
