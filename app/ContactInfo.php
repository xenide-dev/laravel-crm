<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    protected $fillable = [
        'name', 'value'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
