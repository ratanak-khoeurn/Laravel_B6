<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Friend;
use App\Models\FriendRequest;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendRequestController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $friends = FriendRequest::where(function ($query) use ($user) {
            $query->where('sender_id', $user->id)
                  ->orWhere('receiver_id', $user->id);
        })->where('status', 'accepted')->get();

        return response()->json($friends);
    }

    public function addfriend(Request $request)
    {
        $user = Auth::user();
        $friend = User::find($request->receiver_id);

        if ($friend) {
            FriendRequest::create([
                'sender_id' => $user->id,
                'receiver_id' => $request->receiver_id,
                'status' => 'pending',
            ]);
            return response()->json(['message' => 'Friend request sent successfully']);
        }

        return response()->json(['message' => 'User not found'], 404);
    }

    public function acceptfriend(Request $request, $id)
    {
        $friendRequest = FriendRequest::find($id);

        if ($friendRequest && $friendRequest->receiver_id == Auth::id()) {
            $friendRequest->update(['status' => $request->status]);

            if ($request->status == 'accepted') {
                Friend::create([
                    'userid1' => $friendRequest->sender_id,
                    'userid2' => $friendRequest->receiver_id,
                ]);
            }

            return response()->json(['message' => 'Friend request accept successfully']);
        }

        return response()->json(['message' => 'Friend request not found or unauthorized'], 404);
    }

    public function rejectfriend($id)
    {
        $friendRequest = FriendRequest::find($id);

        if ($friendRequest && ($friendRequest->sender_id == Auth::id() || $friendRequest->receiver_id == Auth::id())) {
            $friendRequest->delete();
            return response()->json(['message' => 'Friend have been rejected successfully']);
        }

        return response()->json(['message' => 'Friend request not found or unauthorized'], 404);
    }
    public function friendsList()
    {
        $user = Auth::user();
        $friends = Friend::where('userid1', $user->id)
                         ->orWhere('userid2', $user->id)
                         ->get();

        $friendDetails = $friends->map(function ($friend) use ($user) {
            $friendId = $friend->userid1 == $user->id ? $friend->userid2 : $friend->userid1;
            return User::find($friendId);
        });

        return response()->json($friendDetails);
    }
}
