<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarReturn extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }
}
