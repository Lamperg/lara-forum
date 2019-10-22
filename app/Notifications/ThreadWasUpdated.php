<?php

namespace App\Notifications;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ThreadWasUpdated extends Notification
{
    use Queueable;

    /**
     * @var Thread
     */
    protected $thread;

    /**
     * @var Reply
     */
    protected $reply;

    /**
     * Create a new notification instance.
     *
     * @param Thread $thread
     * @param Reply  $reply
     */
    public function __construct(Thread $thread, Reply $reply)
    {
        $this->reply = $reply;
        $this->thread = $thread;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'Temp placeholder'
        ];
    }
}
