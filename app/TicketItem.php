<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketItem extends Model
{
    protected $fillable = [
        "reported_user_id", "status"
    ];

    public function reported_user() {
        return $this->belongsTo(ReportedUser::class);
    }
}
