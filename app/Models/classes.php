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
 public function subjects()
{
    return $this->belongsToMany(Subject::class, 'class_subject', 'class_id', 'subject_id');
}
}
 
