<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ReportedUser extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "full_name", "id_number"
    ];

    // mutators
    public function setFullNameAttribute($value) {
        $this->attributes["full_name"] = ucwords($value);
    }

    public function reports() {
        return $this->hasMany(TicketItem::class);
    }

    public function userOrganization() {
        return $this->morphMany(UserOrganization::class, "organizationable");
    }
}
