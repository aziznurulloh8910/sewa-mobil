<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCriteria extends Model
{
    use HasFactory;

    protected $table = 'sub_criterias';
    protected $guarded = ['id'];

    public function criteria() {
        return $this->belongsTo(Criteria::class);
    }
}
