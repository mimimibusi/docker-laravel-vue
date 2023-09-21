<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class ChatRoom extends Model
{

	public $timestamps = false;

	protected $fillable = [
		'room_name'
	];

	public function users(): BelongsToMany
	{
		return $this->belongsToMany(User::class)->withTimestamps();
	}

	public function chats(): HasMany
	{
		return $this->hasMany(Chat::class);
	}

	public function getChattedRoom()
	{
        $user = Auth::user();
		$chatRoomLists = $user->chatRooms;
		return $chatRoomLists;
	}
}
