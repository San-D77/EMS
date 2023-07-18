<?php

namespace Database\Seeders;

use App\Models\Backend\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = ['Create User','View User', 'Update User', 'Submit Report','View Report','Approve Report'];
        foreach($permissions as $permission){
            Permission::create([
                'title' => $permission,
                'slug' => Str::slug($permission),
                'status' => 1,
            ]);
        }
    }
}
