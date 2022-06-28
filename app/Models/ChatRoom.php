<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;

    public function messages(){
        return $this->hasMany('App\Models\ChatMessage');
    }


    // public function pengisianperjawatans(){
    //     return $this->hasMany(PengisianPerjawatan::class, 'fk_No_Tentera', 'pk_No_Tentera');
    // }
}
