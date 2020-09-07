<?php

namespace App\Notifications;
use App\Report;
use App\Goal;
use App\Objective;
use App\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Jobs\Middleware\NotificationRateLimited;

class NewCommentReportForTeamObjective extends Notification implements ShouldQueue
{
    use Queueable;

    // public $connection = 'redis';
    // public $delay = 60;
    public $tries = 3;
    public $timeout = 3600;
    
    protected $report;
    protected $goal;
    protected $objective;
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
        $this->goal = $report->goal;
        $this->objective = $report->goal->objective;
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
        return ['database'];   
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
            'type' => 'new-comment-report-for-objective-team',
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