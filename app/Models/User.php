<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'shortform',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'two_factor_confirmed_at',
        'email_verified_at',
        'current_team_id',
        'profile_photo_path',
        'profile_photo_url',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * The roles that belong to the user.
     */
    public function eksesais()
    {
        return $this->belongsToMany(Eksesais::class, 'eksesais_user');
    }

    public function rooms()
    {
        return $this->belongsToMany(ChatRoom::class, 'chat_room_users')->withPivot('newMessage');
    }

    public function callsign()
    {
        return $this->hasOne(Callsign::class)->whereDate('tarikh', Carbon::now());
    }
    public function callsigns()
    {
        return $this->hasMany(Callsign::class);
    }

    // public function tokens(){

    // }
}
