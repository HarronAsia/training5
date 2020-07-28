<?php

namespace App\Notifications\For_ADMIN\Category;

use App\Models\Category;
use App\Models\User;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class AddCategoryNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
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
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {

        $category = Category::findOrFail($notifiable->id);
        $user = User::findOrFail(Auth::user()->id);

        return [
            'data' => 'User names ' . ucfirst($user->name) . ' has added a new Category called ' . ucfirst($category->name),
        ];
    }
}
