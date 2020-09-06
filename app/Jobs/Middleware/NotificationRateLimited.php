<?php

namespace App\Jobs\Middleware;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

class NotificationRateLimited
{
  /**
   * Process the queued job.
   *
   * @param  mixed  $job
   * @param  callable  $next
   * @return mixed
   */
  public function handle($job, $next)
  { 
    if(config('queue.default') == 'redis'){
    if($job->queue == 'mailer'){

      Redis::throttle('mailer')
        ->allow(10)->every(15)
        ->then(function () use ($job, $next) {
          // Lock obtained...
          Log::channel('mysql')->info("Se envio un mail", ['type' => 'notifications', 'queue' => $job->queue, 'throttle' => true, 'connection'=> config('queue.default'), 'job' => $job->displayName(), 'user_id' => $job->notifiables[0]->id, 'email' => $job->notifiables[0]->email]);
          $next($job);
        }, function () use ($job) {
          // Could not obtain lock...
          $job->release(5 + rand(15));
      });

    } else {
      Log::channel('mysql')->info("Se envio una notificación", ['type' => 'notifications', 'queue' => $job->queue, 'throttle' => false, 'connection'=> config('queue.default'), 'job' => $job->displayName(), 'user_id' => $job->notifiables[0]->id, 'email' => $job->notifiables[0]->email]);
      $next($job);
      }
    } else {
      Log::channel('mysql')->info("Se envio una notificación", ['type' => 'notifications', 'queue' => $job->queue, 'throttle' => false , 'connection'=> config('queue.default'), 'job' => $job->displayName(), 'user_id' => $job->notifiables[0]->id, 'email' => $job->notifiables[0]->email]);
      $next($job);
    }
  }
}
