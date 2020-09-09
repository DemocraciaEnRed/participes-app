<?php

namespace App\Observers;

use Str;
use App\Report;

class ReportObserver
{
    /**
     * Handle the report "saving" event.
     *
     * @param  \App\Report  $report
     * @return void
     */
    public function saving(Report $report)
    {
        $trace = Str::of($report->title)
            ->append(implode('',($report->tags ?? array())))
            ->replace(' ', '')
            ->lower();
        $report->trace = $trace;
    }

}
