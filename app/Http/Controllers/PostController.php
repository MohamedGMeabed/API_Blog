<?php

namespace App\Http\Controllers;

use App\Events\SendMailToAdminEvent;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Mail\CreatePostMail;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;



class PostController extends Controller
{
public function getAllPosts(){
 
  $posts = Post::all();
  //$this -> authorize($posts,'show');
  return view('post',compact('posts')); 
}


    public function index(){
      $user = auth()->user();
      //dd($user);
      //$post = Post::all()->load('comments');
      $post = Post::where('user_id',$user->id)->get();
      $post -> load('comments');
      //$post = Post::with('comments')->where('user_id',$user->id)->get();
        // return response()->json([
        // $post,
        // 'message' =>"Return Successfully"
        // ]);
      //  $post = Post::with('comments')->get();
      //  return $post;
      return  PostResource::collection($post);
    }

    public function show(Post $post){
      
     // $post =  Post::find($id);
      $this -> authorize($post,'show');
      return new PostResource($post);

      // return response()->json([
      //   $post->comments ,
      //   'message' =>"Return Successfully"
    
      //       ]);
    }


    public function store(PostRequest $request){
      //dd($request->file('image'));
         $post = new Post();
         $post->body = $request->body;
        $post->user_id = auth()->user()->id;
        $post->created_at = Carbon::now();
         $post->save();
        
        // Post::create([
        //     'body'=>$request->body,
        //     'user_id'=>auth()->user()->id,  
        //    ]);

        // return response()->json([
         
        // 'message' =>"Add Post Successfully"]);

        //event(new SendMailToAdminEvent($post));
        
        return new PostResource($post);
      }
      

      // public function update(Request $request , $post_id){
      //   $post = Post::findOrFail($post_id);
      //   $post->body = $request->body;
      //    $post->user_id = $request->user_id;
      //    $post->created_at = Carbon::now();
      //    $post->save();

      // }
      public function update(Request $request,$post_id){
        $post = Post::findOrFail($post_id);
        $post ->update([
           'body'=>$request->body,
            'user_id'=>$request->user_id,  
            'created_at' => Carbon::now()
        ]);

      }


      public function delete($post_id){
        $post=Post::find($post_id);  // Post::where('id','$post_id') -> first();

        $post->delete();
      }

}
