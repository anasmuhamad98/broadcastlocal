<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListA extends Model
{
    use HasFactory;

    protected $fillable = [
        'Grouper',
        'List_A',
        'Meaning'
    ];
}
