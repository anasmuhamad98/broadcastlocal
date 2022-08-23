<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eksesais extends Model
{
    use HasFactory;

     /**
     * The users that belong to the role.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'eksesais_user');
    }

    public function callsigns()
    {
        return $this->hasMany(CallsignEksesais::class);
    }

    public function rooms()
    {
        return $this->hasMany(ChatRoom::class);
    }
}
