<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserOrganization extends Model
{
    protected $fillable = [
        "organization_id", "organization_position"
    ];


    public function organization() {
        return $this->belongsTo(Organization::class);
    }

    public function organizationable() {
        return $this->morphTo();
    }
}
