<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // super admin

        User::create([
            'name' => 'Sandip Dangal',
            'email' => 'sandipdangal77@gmail.com',
            'password' => bcrypt('password'),
            'alias_name' => 'Ray',
            'slug' => 'ray',
        ]);
    }
}
