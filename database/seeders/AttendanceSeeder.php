<?php

namespace Database\Seeders;

use App\Models\Backend\Attendance;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Factories\Backend\AttendanceFactory;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Attendance::factory(random_int(5,User::count()))->create();
    }
}
