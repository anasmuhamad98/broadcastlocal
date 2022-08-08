<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grouper extends Model
{
    use HasFactory;

    protected $fillable = [
        'Grouper',
        'Meaning',
        'Tack_1',
        'Tack_2',
        'Tack_3',
        'Tack_4',
        'Free_Text_Tack_1',
        'Free_Text_Tack_2',
        'Free_Text_Tack_3',
        'Free_Text_Tack_4',
        'Free_Text_Tack_5', '
        Free_Text_Tack_6',
        'List_A',
        'List_B',
        'List_C',
        'Free_Text_List'
    ];
}
