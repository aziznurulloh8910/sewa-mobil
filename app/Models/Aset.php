<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aset extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'registration_number',
        'asset_code',
        'location',
        'brand_type',
        'procurement_year',
        'quantity',
        'acquisition_cost',
        'condition',
        'description',
        'recorded_value',
        'accumulated_depreciation',
        'total_depreciation'
    ];
}
