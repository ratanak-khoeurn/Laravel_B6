<?php

namespace App\Http\Controllers\Like;

use App\Http\Controllers\Controller;
use App\Models\Share\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function likeShare(Request $request){
        $request->validate([
            'share_id' =>'required',
        ]);
        $liked = Like::where('share_id',$request->share_id)->where('user_id', Auth()->user()->id)->first();
        if($liked){
            $liked->delete();
            return response("Unliked");
        }
        Like::create([
            'share_id' => $request->share_id,
            'user_id' => Auth()->user()->id,
        ]);
        return response("Liked");
    }


}
