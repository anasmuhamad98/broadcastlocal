<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;
    public function room()
    {
        return $this->hasOne('App\Models\ChatRoom', 'id', 'chat_room_id');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function rooms(){
        return $this->hasMany('App\Models\ChatRoom', 'id', 'chat_room_id');
    }

    public function callsign()
    {
        return $this->hasOne(Callsign::class, 'user_id', 'user_id')->where('tarikhhari', Carbon::now()->day);
    }
}
