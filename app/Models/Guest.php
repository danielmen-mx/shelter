<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\MatchTrait;

class Guest extends Model
{
    use HasFactory, MatchTrait;

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
        $guestList = GuestList::where('guest_id', $this->id)->first();

        if (!$guestList) return;

        return $guestList->tickets;
    }
}
