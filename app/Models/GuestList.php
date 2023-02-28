<?php

namespace App\Models;

use App\Models\Traits\HasUuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Traits\MatchTrait;

class GuestList extends Model
{
    use HasFactory, MatchTrait, HasUuidTrait;

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
        'guest_id',
        'tickets'
    ];

    protected $casts = [
        'tickets' => 'integer',
    ];

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function response()
    {
        return $this->belongsTo(Response::class);
    }

    public function getTickets()
    {
        return $this->tickets;
    }
}
