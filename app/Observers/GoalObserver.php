<?php

namespace App\Observers;

use Str;
use App\Goal;

class GoalObserver
{
    /**
     * Handle the goal "saving" event.
     *
     * @param  \App\Goal  $goal
     * @return void
     */
    public function saving(Goal $goal)
    {
        $trace = Str::of($goal->title)
            ->append($goal->indicator)
            ->append($goal->indicator_unit)
            ->append($goal->indicator_frequency)
            ->append($goal->source)
            ->replace(' ', '')
            ->lower();
        $goal->trace = $trace;
    }

}
