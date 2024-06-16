<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Resources\Post\PostResource;
use App\Models\Post\Like;
use App\Models\Post\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    
    public function indexPost(){
        $posts = Post::getAllPosts();
        $posts = PostResource::collection($posts);
        return response(['sucess' => true, 'posts' => $posts]);
    }
    
    public function addPost(Request $request){
        $request->validate([
            'image_url' => 'required',
            'description' => 'required',
        ]);
        $post = Post::create([
            'image_url' => $request->image_url,
            'description' => $request->description,
            'user_id' => Auth()->user()->id,
        ]);
        return response($post);
    }
    public function addLike(Request $request){
        $request->validate([
            'post_id' =>'required',
        ]);
        $liked = Like::where('post_id',$request->post_id)->where('user_id', Auth()->user()->id)->first();
        if($liked){
            $liked->delete();
            return response("Unliked");
        }
        Like::create([
            'post_id' => $request->post_id,
            'user_id' => Auth()->user()->id,
        ]);
        return response("Liked");
    }

    public function getPosts($id){
        $post = Post::find($id);
        return response(new PostResource($post));
    }
}
