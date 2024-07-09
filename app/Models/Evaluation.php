<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function subCriteria() {
        return $this->belongsTo(SubCriteria::class, 'sub_criteria_id');
    }

}
