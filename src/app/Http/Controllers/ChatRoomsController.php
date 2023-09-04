<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatRoomsController extends Controller
{
    public function __construct(
        ChatRoom $chatRoom
    )
    {
        $this->chatRoom = $chatRoom;
    }

    public function createChatRoom(Request $request)
    {
        $userId = Auth::id();
        $roomName = $request->roomName;
        $chatRoom = $this->chatRoom->create([
            'room_name' => $roomName
        ]);
        $chatRoom->users()->attach($userId);
        return $chatRoom->id;
    }

    //ーーーーーーーー未開発機能ーーーーーーーーー

    // public function joinChatRoom(Request $request)
    // {
    //     $this->chatRoom->find($request->roomId)->users()->attach($request->userId);
    // }

    // public function addChatRoom($params)
    // {
    //     \Log::info(print_r($params->chatRoom, true));
    //     $params->chatRoom->users()->attach($params->userId);
    // }

    // public function leaveChatRoom(Request $request)
    // {
    //     $this->chatRoom->find($requeset->roomId)->users()->detach($request->userId);
    // }
}
