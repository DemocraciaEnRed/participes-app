<?php

if (! function_exists('app_setting')) {
   function app_setting($key, $default = null)
    {
        // Barryvdh\Debugbar\Facade::info($default);
        $value = Cache::rememberForever($key, function () use ($key, $default) {
          $setting = \App\Setting::where('name',$key)->first();
          if(is_null($setting)){
            return null;
          }
          if(is_null($setting->casted_value) && !is_null($default)){
            return $default;
          }

          return $setting->casted_value;
        });
        return is_null($value) ? $default : $value;
    }
}