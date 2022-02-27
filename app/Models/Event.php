<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_periode',
        'end_periode',
    ];

    public function productEvents()
    {
        return $this->hasMany(ProductEvent::class);
    }
}
