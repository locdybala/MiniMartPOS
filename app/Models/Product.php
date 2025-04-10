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
        return $this->latestImport ? $this->latestImport->unit_price : null;
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Quan hệ với chi tiết phiếu nhập
    public function importDetails()
    {
        return $this->hasMany(ImportOrderDetail::class, 'product_id');
    }

// Quan hệ với chi tiết đơn hàng (bán)
    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class, 'product_id');
    }

// Số lượng đã nhập
    public function getImportedQuantityAttribute()
    {
        return $this->importDetails->sum('quantity');
    }

// Số lượng đã bán
    public function getSoldQuantityAttribute()
    {
        return $this->orderDetails->sum('quantity');
    }
}
