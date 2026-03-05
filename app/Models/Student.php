<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'name',
        'father_name',
        'class',
        'mobile',
        'address',
        'gender',
        'age',
        'email',
        'password',
        'image'
    ];

    protected $hidden = [
        'password'
    ];
}