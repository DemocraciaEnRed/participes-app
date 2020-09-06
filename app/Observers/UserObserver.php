<?php

namespace App\Observers;

use Str;
use App\User;

class UserObserver
{
    /**
     * Handle the user "saving" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function saving(User $user)
    {
        $trace = Str::of($user->name)
            ->append($user->surname)
            ->append($user->email)
            ->replace(' ', '')
            ->lower();
        $user->trace = $trace;
    }
}
