<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'eksesais_id',
        'name',
        'shortform',
        'isShow',
    ];

    public function messages(){
        return $this->hasMany('App\Models\ChatMessage');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'chat_room_users')->withPivot('newMessage');
    }

    // public function hasmanyusers()
    // {
    //     return $this->hasMany(User::class);
    // }
}
