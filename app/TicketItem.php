<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketItem extends Model
{
    protected $fillable = [
        "reported_user_id", "status", "ticket_id"
    ];

    public function reported_user() {
        return $this->belongsTo(ReportedUser::class);
    }
}
