<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RakeCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'Rake_Code',
        'Meaning'
    ];
}
