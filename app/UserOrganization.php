<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserOrganization extends Model
{
    public function organization() {
        return $this->belongsTo(Organization::class);
    }

    public function organizationable() {
        return $this->morphTo();
    }
}
