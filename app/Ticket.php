<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        "message", "status", "user_id", "input_names"
    ];

    public function ticket_item() {
        return $this->hasMany(TicketItem::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
