<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlacklistUser extends Model
{
    protected $fillable = [
        "fname", "mname", "lname", "id_number"
    ];

    public function userOrganization() {
        return $this->morphMany(UserOrganization::class, "organizationable");
    }
}
