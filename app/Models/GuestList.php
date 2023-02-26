<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class GuestList extends Model
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

    public function match(Request $request)
    {
        if ($request->first_name != $this->first_name) return false;
        if ($request->second_name != $this->second_name) return false;
        if ($request->first_last_name != $this->first_last_name) return false;
        if ($request->second_last_name != $this->second_last_name) return false;

        return true;
    }
}
