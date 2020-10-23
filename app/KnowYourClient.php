<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KnowYourClient extends Model
{
    protected $fillable = [
        "id_number", "ign", "club_id", "union_id", "full_name", "fname", "mname", "lname", "suffix", "email", "phone_number"
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
