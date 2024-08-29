<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $table = 'toddler_schools';

    public function categoryRef(){
        return $this->belongsTo(Category::class, 'category_id');
    }
}
