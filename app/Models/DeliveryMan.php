<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class DeliveryMan extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'username', 'password','image','phone_number'
   ];

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function sales(){
        return $this->hasMany(Sale::class);
    }
}
