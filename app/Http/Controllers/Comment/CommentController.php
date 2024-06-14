<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment\Comment;

class CommentController extends Controller
{
    public function addComment(Request $request){
        $request->validate([
            'post_id' => 'required',
            'body' => 'required',
        ]);
        $comment = Comment::create([
            'post_id' => $request->post_id,
            'body' => $request->body,
            'user_id' => auth()->user()->id,
        ]);
        return response($comment);
    }
}
