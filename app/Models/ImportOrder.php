<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportOrder extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function details()
    {
        return $this->hasMany(ImportOrderDetail::class);
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
