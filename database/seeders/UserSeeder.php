<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Mohammad Slo',
            'email' => 'm@slo.com',
            'password' => Hash::make('password'),
        ]);

        DB::table('users')->insert([
            'name' => 'System Admin',
            'email' => 'sys@slo.sy',
            'password' => Hash::make('password'),

        ]);
    }
}
