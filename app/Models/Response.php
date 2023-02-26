<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'guest_id',
        'guest_list_id',
        'tickets'
    ];

    protected $casts = [
        'tickets' => 'integer',
    ];

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function guestList()
    {
        return $this->belongsTo(GuestList::class);
    }

    public function getAssistance()
    {
        return $this->guest->assistance;
    }

    public function getTickets()
    {
        return $this->guestList->tickets;
    }

    public function getTotalTickets()
    {
        // add logic to get all the tickets of all the responses and return only the total quantity
    }
}
