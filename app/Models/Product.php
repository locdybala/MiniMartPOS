<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function latestImport()
    {
        return $this->hasOne(ImportOrderDetail::class, 'product_id')->latest();
    }

    public function getLatestImportPriceAttribute()
    {
        return $this->latestImport ? $this->latestImport->price : null;
    }
}
