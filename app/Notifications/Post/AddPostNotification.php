<?php

namespace App\Notifications\Post;

use App\Models\Community;
use App\Models\Post;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AddPostNotification extends Notification
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
        
        $post = Post::findOrFail($notifiable->id);
        
        $community = Community::findOrFail($post->community_id);
        
        $user = User::findOrFail(Auth::user()->id);

        return [
            'data' => 'User names ' . ucfirst($user->name) . ' has added a new Post on ' . ucfirst($community->title),
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
