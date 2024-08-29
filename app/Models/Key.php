<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
    use HasFactory;

    protected $table = 'toddler_keys';

    public function kitRef(){
        return $this->belongsTo(Kit::class, 'kit_id');
    }
}
