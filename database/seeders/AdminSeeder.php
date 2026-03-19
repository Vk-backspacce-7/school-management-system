<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
   

public function run()
{
    $role = Role::firstOrCreate(['name' => 'principal']);

    $user = User::create([
        'name' => 'Principal',
        'email' => 'admin@gmail.com',
        'password' => Hash::make('12345678'),
    ]);

    $user->assignRole($role);
}
}
