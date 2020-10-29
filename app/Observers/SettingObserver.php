<?php

namespace App\Observers;

use Cache;
use Str;
use App\Setting;

class SettingObserver
{
    /**
     * Handle the report "saving" event.
     *
     * @param  \App\Report  $report
     * @return void
     */
    public function saving(Setting $setting)
    {
      if($setting->cached){
        Cache::put($setting->name, $setting->casted_value);
      }
    }
}
