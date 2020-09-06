<?php

namespace App\Notifications;
use App\Report;
use App\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Jobs\Middleware\NotificationRateLimited;

class NewCommentReportForAuthor extends Notification implements ShouldQueue
{
    use Queueable;

    // public $connection = 'redis';
    // public $delay = 60;
    public $tries = 3;
    public $timeout = 3600;
    
    protected $report;
    protected $comment;
    
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
    public function __construct(Report $report, Comment $comment)
    {
        $this->report = $report;
        $this->comment = $comment;
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
                    ->subject('Han hecho un nuevo comentario en tu reporte')
                    ->markdown('mail.comments.newForAuthor', ['user' => $notifiable, 'report' => $this->report, 'comment' => $this->comment]);
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
            'type' => 'new-comment-report-for-author',
            'report' => [
                'id' => $this->report->id,
                'title' => $this->report->title,
                'type' => $this->report->type,
                'icon' => $this->report->type_icon,
                'label' => $this->report->type_label
            ],
            'goal' => [
                'id' => $this->report->goal->id,
                'title' => $this->report->goal->title
            ],
            'objective' => [
                'id' => $this->report->goal->objective->id,
                'title' => $this->report->goal->objective->title
            ],
            'comment' => [
                'id' => $this->comment->id,
                'author' => $this->comment->user->fullname,
                'content' => $this->comment->content
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