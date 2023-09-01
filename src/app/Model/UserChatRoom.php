<?php

namespace App\Model;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class UserChatRoom extends Model
{
    public function getChattedRoom($userId)
    {
        $chatRoomList = self::where('user_id', '!=', $userId)
            ->join('chat_rooms', 'user_chat_rooms.room_id', '=', 'chat_rooms.id')
                ->get();
        return $chatRoomList;
    }
}
