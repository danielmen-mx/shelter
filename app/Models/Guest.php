<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'second_name',
        'first_last_name',
        'second_last_name',
        'assistance'
    ];

    protected $casts = [
        'assistance' => 'boolean',
    ];

    public function response()
    {
        return $this->belongsTo(Response::class);
    }

    public function guestList()
    {
        return $this->belongsTo(GuestList::class);
    }

    public function getAssistance()
    {
        return $this->assistance;
    }

    public function getTickets()
    {
        return $this->guestList->tickets;
    }
}
