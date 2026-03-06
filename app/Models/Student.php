<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Foundation\Auth\student as Authenticatable;
 use Spatie\Permission\Traits\HasRoles;
 

class Student extends Model
{
  use HasFactory , HasRoles;

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
'password',
'remember_token',
];

protected function casts(): array
{
return [
'email_verified_at' => 'datetime',
'password' => 'hashed',
];
}
}