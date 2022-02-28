<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'qty',
    ];

    public function isValidEventStock($data)
    {
        $qtyLimit = floor((double)$this->qty * 0.90);
        if ((double)$data->product_event_qty <= $qtyLimit) {
            return true;
        }

        return false;
    }
}
