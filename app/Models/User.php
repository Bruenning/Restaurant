<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model 
{ 
    use  HasFactory;

    protected $table = 'user';

    // The attributes that are mass assignable.
    protected $fillable = [
        'email',
        'password',
        'name',
        'is_admin',
        'remember_token'
    ];

    // The attributes that should be hidden for arrays.
    protected $hidden = [
        'password',
        'remember_token',
        'is_admin'
    ];


    // Get the user's reservations.

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // Get the user's is_admin.
    
    public function isAdmin()
    {
        return $this->is_admin;
    }

    // create a new user

    public static function create(array $attributes = [])
    {
        $user = new User();
        $user->email = $attributes['email'];
        $user->password = $attributes['password'];
        $user->name = $attributes['name'];
        $user->remember_token = $attributes['remember_token'];
        $user->is_admin = false;

        $user->save();

        return $user;
    }

    /**
     * scope
     */

    public function scopeAdmin($query)
    {
        return $query->where('is_admin', true);
    }


}
