<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{
	public function __construct(
		Chat $chat,
		ChatRoom $chatRoom
	)
	{
		$this->chat = $chat;
		$this->chatRoom = $chatRoom;
	}

	public function sendMessage(Request $request)
	{
		$userId = Auth::id();
		return $this->chat->createChat($request->params, $userId);
	}
}
