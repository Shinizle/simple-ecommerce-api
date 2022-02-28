<?php

namespace App\Models;

use Carbon\Carbon;
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
        'is_active'
    ];

    public function productEvents()
    {
        return $this->hasMany(ProductEvent::class);
    }


    public function isInPeriode()
    {
        $currentTime = Carbon::now();
        if($currentTime->between($this->start_periode, $this->end_periode, true)){
            return true;
        }

        return false;
    }
}
