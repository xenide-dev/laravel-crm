<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        "name", "type", "added_by_id", "id_number"
    ];

    public function userOrganization() {
        return $this->hasMany(UserOrganization::class);
    }
}
