<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Admin;
use Illuminate\Support\Facades\Mail;
use App\Mail\CreatePostMail;
use App\Notifications\SendNotifyToAdmin;
use Illuminate\Support\Facades\Notification;
use App\Models\User;


class SendEmailToAdminJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $post;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($post)
    {
        $this->post = $post;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $admin = Admin::get()->first();
        //Mail::to($admin)->send(new CreatePostMail($this->post));
        Notification::send(User::all(),new SendNotifyToAdmin($this->post));
    }
}
