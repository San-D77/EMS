<?php

namespace Database\Seeders;

use App\Models\Backend\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'title' => 'Superadmin',
            'slug' => 'superadmin',
            'status' => 1,
        ]);
        Role::create([
            'title' => 'Admin',
            'slug' => 'admin',
            'status' => 1,
        ]);
        Role::create([
            'title' => 'User',
            'slug' => 'user',
            'status' => 1,
        ]);
    }
}
