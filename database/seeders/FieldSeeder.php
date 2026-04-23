<?php

namespace Database\Seeders;

use App\Models\Field;
use Illuminate\Database\Seeder;

class FieldSeeder extends Seeder
{
    public function run(): void
    {
        $fields = [
            [
                'name' => 'Lapangan Futsal International',
                'foto_lapangan' => 'images/futsal_international.jpg',
                'type' => 'Futsal',
                'price' => 150000,
                'capacity' => 10,
                'status' => 'available',
                'description' => 'Lapangan futsal dengan standar internasional dan rumput sintetis berkualitas tinggi.',
            ],
            [
                'name' => 'Lapangan Futsal Standard',
                'foto_lapangan' => 'images/futsal_standard.jpg',
                'type' => 'Futsal',
                'price' => 100000,
                'capacity' => 10,
                'status' => 'available',
                'description' => 'Lapangan futsal standar dengan fasilitas lengkap.',
            ],
            [
                'name' => 'Lapangan Badminton 1',
                'foto_lapangan' => 'images/badminton_1.jpg',
                'type' => 'Badminton',
                'price' => 50000,
                'capacity' => 4,
                'status' => 'available',
                'description' => 'Lapangan badminton dengan lantai kayu parket.',
            ],
            [
                'name' => 'Lapangan Badminton 2',
                'foto_lapangan' => 'images/badminton_2.jpg',
                'type' => 'Badminton',
                'price' => 50000,
                'capacity' => 4,
                'status' => 'available',
                'description' => 'Lapangan badminton dengan lantai vinyl standar BWF.',
            ],
            [
                'name' => 'Lapangan Basket',
                'foto_lapangan' => 'images/basket.jpg',
                'type' => 'Basket',
                'price' => 200000,
                'capacity' => 12,
                'status' => 'available',
                'description' => 'Lapangan basket indoor dengan ring standar NBA.',
            ],
        ];

        foreach ($fields as $field) {
            Field::create($field);
        }
    }
}
