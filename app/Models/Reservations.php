<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservations extends Model
{
    use HasFactory;

    protected $table = 'reservations';

    // The attributes that are mass assignable.
    protected $fillable = [
        'id',
        'dateReservation',
        'timeReservation',
        'user_id',
    ];

    // The attributes that should be cast.
    protected $casts = [
        'dateReservation' => 'datetime',
        'timeReservation' => 'datetime',
    ];

    
    protected $appends = [
        'user',
    ];
 
    // Get the user that owns the reservation.
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Get the user that owns the reservation.
    public function getUserAttribute()
    {
        return $this->user()->first(['name', 'email']);
    }

    // create a new reservation

    public static function create($request)
    {
        $reservations = new Reservations();
        $reservations->dateReservation = $request['dateReservation'];
        $reservations->timeReservation = $request['timeReservation'];
        $reservations->user_id = $request['user_id'];
        $reservations->save();
        return $reservations;
    }
}
