<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Memanggil model User
use Illuminate\Support\Facades\Hash; // Untuk mengenkripsi password

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat akun Admin secara otomatis
        User::create([
            'nama_lengkap' => 'Admin PPID',
            'email' => 'admin@fmipa.unila.ac.id',
            'password' => Hash::make('rahasia123'), // Kata sandi rahasia untuk admin
            'role' => 'admin',
        ]);
    }
}
