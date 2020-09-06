<?php

namespace App\Notifications;
use App\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
// use Illuminate\Queue\SerializesModels;
use Illuminate\Notifications\Notification;
use App\Jobs\Middleware\NotificationRateLimited;

class NewEvent extends Notification implements ShouldQueue
{
    use Queueable;

    // public $connection = 'redis';
    // public $delay = 60;
    public $tries = 3;
    public $timeout = 3600;
    
    protected $event;
    
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
    public function __construct(Event $event)
    {
        $this->event = $event;
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
        
        return (new MailMessage)
                    ->subject('¡Nuevo evento en Participes!')
                    ->markdown('mail.events.new', ['user' => $notifiable, 'event' => $this->event]);
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
            'type' => 'new-event',
            'event' => [
                'id' => $this->event->id,
                'title' => $this->event->title
            ]
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