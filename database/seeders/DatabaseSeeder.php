<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Admin Nopal',
            'email' => 'admin@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin', // Pastiin kolom 'role' ada di migrasi tabel user lu!
        ]);

        \App\Models\User::create([
            'name' => 'User Biasa',
            'email' => 'user@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'user',
        ]);

        $this->call([
            FieldSeeder::class,
            ScheduleSeeder::class,
            SlotSeeder::class,
        ]);
    }
}
