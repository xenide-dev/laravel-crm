<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ReportedUser extends Model
{
    protected $fillable = [
        "fname", "mname", "lname", "full_name", "id_number"
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
}
