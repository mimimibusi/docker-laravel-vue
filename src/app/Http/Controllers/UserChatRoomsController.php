<?php

namespace App\Http\Controllers;

use App\Model\UserChatRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserChatRoomsController extends Controller
{
    //        
    public function __construct
    (
        UserChatRoom $userChatRoom
    )
    {
        $this->userChatRoom = $userChatRoom;
    }
    public function getChattedRoomLists(){
        $userId = Auth::id();
        $chatRoomList = $this->userChatRoom->getChattedRoom($userId);
        Log::info($chatRoomList);
        return $chatRoomList;
    }
}
