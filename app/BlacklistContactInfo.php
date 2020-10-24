<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlacklistContactInfo extends Model
{
    protected $fillable = [
        "name", "value",
    ];

    public function blacklist() {
        return $this->belongsTo(BlacklistUser::class);
    }
}
