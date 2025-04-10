<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable implements CanResetPasswordContract

{
    use CanResetPassword;
    use HasFactory, Notifiable;
    protected $fillable = ['name', 'email', 'password', 'phone', 'customer_group_id'];
    protected $hidden = ['password', 'remember_token'];


    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function customerGroup()
    {
        return $this->belongsTo(CustomerGroup::class);
    }
}
