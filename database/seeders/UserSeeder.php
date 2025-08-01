<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'email'=>'admin@gmail.com',
                'email_verified_at' => null,
                'password'=>Hash::make('12345'),
                'role'=> 'admin',
                'is_active'=>true,
                'remember_token'=>null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'email'=>'guru@gmail.com',
                'email_verified_at' => null,
                'password'=>Hash::make('12345'),
                'role'=> 'guru',
                'is_active'=>true,
                'remember_token'=>null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'email'=>'kepsek@gmail.com',
                'email_verified_at' => null,
                'password'=>Hash::make('12345'),
                'role'=> 'kepsek',
                'is_active'=>true,
                'remember_token'=>null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'email'=>'murid@gmail.com',
                'email_verified_at' => null,
                'password'=>Hash::make('12345'),
                'role'=> 'murid',
                'is_active'=>true,
                'remember_token'=>null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
