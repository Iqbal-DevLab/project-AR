<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        User::factory()->create([
            'username' => 'Iqbal',
            'nik_karyawan' => 'admin',
            'password' => bcrypt('admin'),
            'role_id' => 1,
            'last_login' => Carbon::now(),
            'update_by' => 'admin',
        ]);

        User::factory()->create([
            'username' => 'Sales',
            'nik_karyawan' => 'sales',
            'password' => bcrypt('password'),
            'role_id' => 2,
            'last_login' => Carbon::now(),
            'update_by' => 'admin',
        ]);

        User::factory()->create([
            'username' => 'Rizal',
            'nik_karyawan' => '03.01.0039',
            'password' => bcrypt('password'),
            'role_id' => 3,
            'last_login' => Carbon::now(),
            'update_by' => 'admin',
        ]);
    }
}
