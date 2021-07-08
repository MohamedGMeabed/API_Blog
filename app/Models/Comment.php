<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $timestaps = false;

    protected $fillable = ['content','user_id','post_id'];



    
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function post(){
        return $this->belongsTo(Post::class,'post_id');
    }
}
