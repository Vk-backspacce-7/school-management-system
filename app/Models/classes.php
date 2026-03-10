<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class classes extends Model
 {
 protected $fillable = ['class', 'section'];

public function students()
{
    return $this->hasMany(Student::class,'class_id');
}


}
 
