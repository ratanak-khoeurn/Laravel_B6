<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use App\Models\Post\Post;
use App\Models\Post\Like;

class PostController extends Controller
{
    public function addPost(Request $request){

        $request->validate([
            'title' =>'required',
            'description' =>'required'

        ]);

        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->user()->id,
        ]);

        return response($post);

    }

    
    public function addLike(Request $request){
        // $post = Post::find($request->post_id);
        // $post->likes()->create([
        //     'user_id' => auth()->user()->id,
        // ]);

        // return response($post->likes()->count());

        $request->validate([
            'post_id' =>'required'
        ]);

        $liked = Like::where('post_id', $request->post_id)->where('user_id', auth()->user()->id)->first();
        if($liked){
            $liked->delete();
            return response("UnLiked");
        }

        Like::create([
            'post_id' => $request->post_id,
            'user_id' => auth()->user()->id,
        ]);

        return response("Liked");

    }

    public function getPost($id){
        $post = Post::find($id);
        $post = new PostResource($post);
       
        // return response($posts);
    }
}
