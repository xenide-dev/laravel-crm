<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $fillable = [
        'fname', 'mname', 'lname', 'id_number', 'phone_number', 'email'
    ];

    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];

    protected $appends = ['lastSeen'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_online_at' => 'datetime',
    ];

    public function getLastSeenAttribute(){
        return $this->last_online_at;
    }

    public function contactInfo(){
        return $this->hasMany(ContactInfo::class);
    }
}
