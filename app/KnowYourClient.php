<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KnowYourClient extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "id_number", "ign", "club_id", "union_id", "full_name", "fname", "mname", "lname", "suffix", "email", "phone_number", "uuid_kyc",
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
