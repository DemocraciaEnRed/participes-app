<?php

namespace App\Notifications;
use App\Objective;
use App\Goal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
// use Illuminate\Queue\SerializesModels;
use Illuminate\Notifications\Notification;
use App\Jobs\Middleware\NotificationRateLimited;

class EditObjective extends Notification implements ShouldQueue
{
    use Queueable;

    // public $connection = 'redis';
    // public $delay = 60;
    public $tries = 3;
    public $timeout = 3600;
    
    protected $objective;
    
    public function middleware(){
        return [new NotificationRateLimited];
    }

    /**
     * Determine which queues should be used for each notification channel.
     *
     * @return array
     */
    public function viaQueues()
    {
        return [
            'mail' => 'mailer',
            'database' => 'default',
        ];
    }

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Objective $objective)
    {
        $this->objective = $objective;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return explode(',',$notifiable->notification_preferences);   
    }   

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {   
        
        $url = route("objectives.index", ['objectiveId' => $this->objective->id]);
        return (new MailMessage)
              ->subject('Han editado un objetivo que sigues en Participes')
              ->greeting('¡Hola!')
              ->line("Acaban de editar el objetivo \"{$this->objective->title}\". ¡Te invitamos a que explores los cambios!")
              ->action('Ver objetivo', $url)
              ->line('PD: Te llegan estas notificaciones porque estas suscripto a las notificaciones del objetivo.');
    }

    /**
     * Get the database representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'type' => 'edit-objective',
            'objective' => [
                'id' => $this->objective->id,
                'title' => $this->objective->title
            ],
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

}
