<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $fillable = [
        'fname', 'mname', 'lname', 'full_name', 'suffix', 'id_number', 'phone_number', 'email', 'temp_password', 'password'
    ];

    protected $hidden = [
        'password', 'temp_password', 'remember_token', 'api_token'
    ];

    protected $appends = ['lastSeen'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_online_at' => 'datetime',
    ];

    public function getLastSeenAttribute(){
        return $this->last_online_at;
    }

    // mutators
    public function setFNameAttribute($value) {
        $this->attributes["fname"] = ucwords($value);
    }
    public function setMNameAttribute($value) {
        $this->attributes["mname"] = ucwords($value);
    }
    public function setLNameAttribute($value) {
        $this->attributes["lname"] = ucwords($value);
    }
    public function setSuffixAttribute($value) {
        $this->attributes["suffix"] = ucwords($value);
    }
    public function setFullNameAttribute($value) {
        $this->attributes["full_name"] = ucwords($value);
    }

    public function contactInfo(){
        return $this->hasMany(ContactInfo::class);
    }

    public function userPermission() {
        return $this->hasMany(UserPermission::class);
    }

    public function userOrganization() {
        return $this->morphMany(UserOrganization::class, "organizationable");
    }
}
