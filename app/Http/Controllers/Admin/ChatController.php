<?php

namespace App\Http\Controllers\Admin;

use App\Events\ChatEvent;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChatController extends Controller
{
    public function index()
    {
        $adminIds = User::where('role', 'admin')->pluck('id')->toArray();

        $senders = Chat::select('sender_id')
            ->whereIn('receiver_id', $adminIds)
            ->whereNotIn('sender_id', $adminIds)
            ->selectRaw('MAX(created_at) as latest_message_sent')
            ->groupBy('sender_id')
            ->orderByDesc('latest_message_sent')
            ->get();

        return view('admin.chat.index', compact('senders'));
    }

    public function getConversation(string $senderId) : Response
    {
        $adminIds = User::where('role', 'admin')->pluck('id')->toArray();

        Chat::where('sender_id', $senderId)
            ->whereIn('receiver_id', $adminIds)
            ->where('seen', 0)
            ->update(['seen' => 1]);

        $messages = Chat::where(function($q) use ($senderId, $adminIds) {
                $q->where('sender_id', $senderId)->whereIn('receiver_id', $adminIds);
            })
            ->orWhere(function($q) use ($senderId, $adminIds) {
                $q->whereIn('sender_id', $adminIds)->where('receiver_id', $senderId);
            })
            ->with(['sender'])
            ->orderBy('created_at', 'asc')
            ->get();

        return response($messages);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => ['required', 'max:1000'],
            'receiver_id' => ['required', 'integer']
        ]);

        $chat = new Chat();
        $chat->sender_id = auth()->user()->id; // Reply karne wale Admin ki ID
        $chat->receiver_id = $request->receiver_id; // Client ki ID
        $chat->message = $request->message;
        $chat->save();

        $userAvatar = auth()->user()->avatar;
        $avatar = $userAvatar ? asset($userAvatar) : asset('frontend/images/default-avatar.jpg');
        $senderId = auth()->user()->id;

        broadcast(new ChatEvent($request->message, $avatar, $request->receiver_id, $senderId))->toOthers();

        return response(['status' => 'success', 'msgId' => $request->msg_temp_id]);
    }
}
