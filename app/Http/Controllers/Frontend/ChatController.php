<?php

namespace App\Http\Controllers\Frontend;

use App\Events\ChatEvent;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => ['required', 'max:1000'],
        ]);

        $admin = User::where('role', 'admin')->orderBy('id', 'asc')->first();

        $chat = new Chat();
        $chat->sender_id = auth()->user()->id;
        $chat->receiver_id = $admin->id;
        $chat->message = $request->message;
        $chat->save();

        $userAvatar = auth()->user()->avatar;
        $avatar = $userAvatar ? asset($userAvatar) : asset('frontend/images/default-avatar.jpg');
        $senderId = auth()->user()->id;

        $adminIds = User::where('role', 'admin')->pluck('id');
        foreach($adminIds as $adminId) {
            broadcast(new ChatEvent($request->message, $avatar, $adminId, $senderId))->toOthers();
        }

        return response(['status' => 'success', 'msgId' => $request->msg_temp_id]);
    }

    public function getConversation(string $senderId = null) : Response
    {
        $userId = auth()->user()->id;
        $adminIds = User::where('role', 'admin')->pluck('id')->toArray();

        Chat::whereIn('sender_id', $adminIds)
            ->where('receiver_id', $userId)
            ->where('seen', 0)
            ->update(['seen' => 1]);

        $messages = Chat::where(function($q) use ($userId, $adminIds) {
                $q->where('sender_id', $userId)->whereIn('receiver_id', $adminIds);
            })
            ->orWhere(function($q) use ($userId, $adminIds) {
                $q->whereIn('sender_id', $adminIds)->where('receiver_id', $userId);
            })
            ->with(['sender'])
            ->orderBy('created_at', 'asc')
            ->get();

        return response($messages);
    }
}
