<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'qty',
        'is_event',
        'event_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function getTotalPrice()
    {
        if ($this->is_event) {
            $product = $this->event->productEvents()->whereProductId($this->product_id)->first();
            $price = (int)$product->event_price * (int)$this->qty;
        } else {
            $price = (int)$this->product->price * (int)$this->qty;
        }

        return $price;
    }

    public function getCartPrice()
    {
        if ($this->is_event) {
            $product = $this->event->productEvents()->whereProductId($this->product_id)->first();
            $price = (int)$product->event_price;
        } else {
            $price = (int)$this->product->price;
        }

        return $price;
    }

    public function isInStock()
    {
        if ($this->is_event) {
            $product = $this->event->productEvents()->whereProductId($this->product_id)->first();
            $stock = (int)$product->product_event_qty;
        } else {
            $stock = (int)$this->product->qty;
        }

        if ($stock >= $this->qty) {
            return true;
        }

        return false;
    }
}
