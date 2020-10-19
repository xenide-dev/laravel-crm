<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserOrganization extends Model
{
    public function organizationable() {
        return $this->morphTo();
    }
}
