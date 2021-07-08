<?php

namespace App\Listeners;

use App\Jobs\SendEmailToAdminJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Admin;
use App\Mail\CreatePostMail;
use Illuminate\Support\Facades\Mail;
use app\Events\SendMailToAdminEvent;

class SendMailToAdminListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    
    public function __construct()
    {
       
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle( SendMailToAdminEvent $event)
    {
        // $admin = Admin::get()->first();
        // Mail::to($admin)->send(new CreatePostMail($event->post));
        dispatch(new SendEmailToAdminJob($event->post));
    }
}
