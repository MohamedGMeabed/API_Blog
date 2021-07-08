<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Post;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendNotifyToAdmin extends Notification implements ShouldBroadcast
{
    use Queueable;

    public $post;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
       $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','broadcast'];
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
                    ->line($this->post->user->name ." Has Created A New Post")
                    ->line("Post Content Is ".$this->post->body)
                    ->action('Aprroving Post', url('/aprrove'.$this->post->id))
                    ->line('Thank you!');
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
            'resource'=>'post',
             'id' =>$this->post->id,
             'body' =>$this->post->body,
             'approve-ulr'=>'approve/'.$this->post->id

        ];
    }


    public function broadcastOn()
    {
        return [
            'channel-post-'.$this->post->id
        ];
    }
}
