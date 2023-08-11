<?php

namespace Database\Seeders;

use App\Models\Backend\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['Admin','Superviser','Maintainer','User'];
        foreach($roles as $role){
            Role::create([
                'title' => $role,
                'slug' => Str::slug($role),
                'status' => 1,
            ]);
        }
    }
}
