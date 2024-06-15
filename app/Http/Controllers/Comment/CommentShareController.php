<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Models\Comment\Comment;
use App\Models\Share\Comment as ShareComment;
use Illuminate\Http\Request;

class CommentShareController extends Controller
{
    public function CommentShare(Request $request){
        $request->validate([
            'share_id' => 'required',
            'body' => 'required',
        ]);
        $comment = ShareComment::create([
            'share_id' => $request->share_id,
            'body' => $request->body,
            'user_id' => auth()->user()->id,
        ]);
        return response($comment);
    }
}
