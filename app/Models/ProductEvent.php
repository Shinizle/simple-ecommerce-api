<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductEvent extends Model
{
    use HasFactory;

    protected $fillable =  [
        'event_id',
        'product_id',
        'product_event_qty',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
