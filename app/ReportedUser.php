<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ReportedUser extends Model
{
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
}
