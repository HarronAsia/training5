<?php

namespace App\Notifications\For_ADMIN\Thread;

use App\Models\User;
use App\Models\Thread;
use Illuminate\Support\Facades\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EditThreadNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toDatabase($notifiable)
    {

        $thread = Thread::findOrFail($notifiable->id);
        $user = User::findOrFail(Auth::user()->id);

        return [
            'data' => 'User names ' . ucfirst($user->name) . 's Thread had been modified to ' . ucfirst($thread->title),
            'user_id' => $user->id,
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
