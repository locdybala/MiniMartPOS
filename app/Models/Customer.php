<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'password', 'phone', 'customer_group_id'];
    protected $hidden = ['password', 'remember_token'];


    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function group()
    {
        return $this->belongsTo(CustomerGroup::class, 'customer_group_id');
    }
}
