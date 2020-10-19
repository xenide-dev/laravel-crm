<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlacklistUser extends Model
{



    public function userOrganization() {
        return $this->morphMany(UserOrganization::class, "organizationable");
    }
}
