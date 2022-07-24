<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallsignEksesais extends Model
{
    use HasFactory;

    protected $fillable = [
        'eksesais_id',
        'callsign1',
        'callsign2',
    ];
}
