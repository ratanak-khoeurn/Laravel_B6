<?php

namespace App\Http\Controllers\Share;

use App\Http\Controllers\Controller;
use App\Http\Resources\Share\ShareResource;
use App\Models\Share\Share;
use Illuminate\Http\Request;
/**
     * @OA\Share(
     *     path="/api/add-share",
     *     tags={"Share"},
     *     summary="Share a user",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="image_url", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="access_token", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="access_token", type="string"),
     *             @OA\Property(property="token_type", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
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
