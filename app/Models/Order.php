<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Builder;
// use App\Models\Product;


class Order extends Model
{
    use HasFactory;


        protected $casts = [
        'order_date' => 'datetime',
    ];
    public function scopeSuccess(Builder $query): void
    {
        $query->where('status', 'Success');
    }

    public function orderItems()
{
    return $this->hasMany(OrderItem::class);
}
}
