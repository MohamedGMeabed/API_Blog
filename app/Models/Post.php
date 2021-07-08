<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\SendMailToAdminEvent;


class Post extends Model
{
    use HasFactory;
    

    protected $dispatchesEvents = [
        'created' => SendMailToAdminEvent::class,
    ];

    protected $table = 'posts';
    protected $timestaps = false;

    protected $fillable = ['body','user_id'];


    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class,'post_id');
    }
    
}
