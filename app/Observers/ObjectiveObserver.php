<?php

namespace App\Observers;

use Str;
use App\Objective;

class ObjectiveObserver
{
    /**
     * Handle the objective "saving" event.
     *
     * @param  \App\Objective  $objective
     * @return void
     */
    public function saving(Objective $objective)
    {
        $trace = Str::of($objective->title)
            ->append(implode('',($objective->tags ?? array())))
            ->replace(' ', '')
            ->lower();
        $objective->trace = $trace;
    }
}
