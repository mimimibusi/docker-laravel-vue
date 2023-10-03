<?php

namespace App\Models;

use App\Models\ChatRoom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chat extends Model
{
    protected $fillable = [
        'user_id',
        'chat',
    ];

    public function chatRoom(): BelongsTo
    {
        return $this->belongsTo(ChatRoom::class);
    }

    public function createChat($messageData, $userId)
    {
        $chatRoom = ChatRoom::where('room_name', '=', $messageData['roomName'])->first();
        $chatRoom->chats()->create(['user_id' => $userId, 'chat' => $messageData['sendMessage']]);
        return $chatRoom->chats;
    }
}
