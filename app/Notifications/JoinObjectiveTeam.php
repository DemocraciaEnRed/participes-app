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

class JoinObjectiveTeam extends Notification implements ShouldQueue
{
    use Queueable;

    // public $connection = 'redis';
    // public $delay = 60;
    public $tries = 3;
    public $timeout = 3600;
    
    protected $objective;
    protected $role;
    
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
    public function __construct(Objective $objective, $role)
    {
        $this->objective = $objective;
        $this->role = $role;
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
        
        $url = route("panel.objectives");
        $mail = (new MailMessage)
              ->subject('Te han agregado al equipo')
              ->greeting('¡Hola!')
              ->line("¡Felicidades! Acaban de agregarte al equipo del objetivo \"{$this->objective->title}\".");
        if($this->role == 'manager'){
          $mail->line("Tu nuevo rol en el equipo es de coordinardor/a.");
        } else {
          $mail->line("Tu nuevo rol en el equipo es de reportero/a.");
        }
        $mail->line("Podrás acceder al panel de administracion del objetivo entrando a \"Mi Panel / Mis objetivos\", o haciendo clic en el siguiente botón")
          ->action('Ver mis objetivos', $url)
          ->line('Por último, te comentamos que automaticamente te hemos suscripto a las notificaciones del objetivo.');
        return $mail;
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
            'type' => 'join-team-objective',
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
