<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use Carbon\Carbon;
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

    public function getChattedRoomLists(){
        $chatRoomLists = $this->chatRoom->getChattedRoom();
        $result = $chatRoomLists->map(function($chatRoomList){
            return [
                'id' => $chatRoomList->id,
                'roomName' => $chatRoomList->room_name,
            ];
        });
        return $result;
    }

    public function createChatRoom(Request $request)
    {
        $userId = Auth::id();
        $roomName = $request->roomName;
        $chatRoom = $this->chatRoom->firstOrCreate([
            'room_name' => $roomName, 'group_flag' => 0
        ]);
        $chatRoom->users()->syncWithoutDetaching([$userId, $request->friendId]);
        return $chatRoom->id;
    }

    public function getChats(Request $request)
    {
        $chatData = $this->chatRoom->getChatRoomByRoomName($request->currentRoomName);
        $result = $chatData->chats->map(function($data){
            return [
                'userId' => $data->user_id,
                'message' => $data->chat,
                'date' => Carbon::parse($data->created_at)->format('Y-m-d H:i:s', DATE_RFC3339),
            ];
        });
        return $result;
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
