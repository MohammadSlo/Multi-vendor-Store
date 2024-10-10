<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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
