<?php

namespace Database\Seeders;

use App\Enum\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'PT Eshan Agro Sentosa',
            'email' => 'admin@eas.com',
            'role' => Role::PARENT_COMPANY,
            'code' => 'EAS',
            'address' => 'Jalan Kodeco No 09, Gunung Antasari, Kecamatan Simpang Empat, Kabupaten Tanah Bumbu, Kalimantan Selatan 72211.',
        ]);
    }
}
