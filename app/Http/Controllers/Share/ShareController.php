<?php

namespace App\Http\Controllers\Share;

use App\Http\Controllers\Controller;
use App\Http\Resources\Share\ShareResource;
use App\Models\Share\Share;
use Illuminate\Http\Request;

class ShareController extends Controller
{
    public function sharePost(Request $request){
        $request->validate([
            'post_id' => 'required',
        ]);
        $share = Share::create([
            'user_id' => Auth()->user()->id,
            'post_id' => $request->post_id,
        ]);
        return response($share);
    }
    public function getShare($id){
        $share = Share::find($id);
        return response(new ShareResource($share));
    }
}
