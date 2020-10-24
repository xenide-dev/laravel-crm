<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlacklistUser extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "fname", "mname", "lname", "full_name", "id_number", "banned_date", "email", "phone_number", "notes"
    ];

    protected $casts = [
        'banned_date' => 'datetime',
    ];

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
    public function setFullNameAttribute($value) {
        $this->attributes["full_name"] = ucwords($value);
    }

    public function userOrganization() {
        return $this->morphMany(UserOrganization::class, "organizationable");
    }

    public function blacklistContactInfo() {
        return $this->hasMany(BlacklistContactInfo::class);
    }
}
