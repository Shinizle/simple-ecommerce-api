<?php

namespace App\Models;

use App\Contracts\IOrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model implements IOrderStatus
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_id',
        'customer_delivery_name',
        'customer_delivery_address',
        'customer_delivery_phone',
        'delivery_fee',
        'discount',
        'price',
        'subtotal',
        'status',
        'note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
