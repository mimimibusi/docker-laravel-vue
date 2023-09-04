<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

	public function getChattedRoom()
	{
        $user = Auth::user();
		$chatRoomLists = $user->chatRooms;
		return $chatRoomLists;
	}
}
