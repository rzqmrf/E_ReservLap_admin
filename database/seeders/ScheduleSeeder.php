<?php

namespace Database\Seeders;

use App\Models\Field;
use App\Models\Schedule;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $fields = Field::all();
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        foreach ($fields as $field) {
            foreach ($days as $day) {
                Schedule::create([
                    'field_id' => $field->id,
                    'day_of_week' => $day,
                    'open_time' => '08:00:00',
                    'close_time' => '22:00:00',
                    'is_open' => true,
                ]);
            }
        }
    }
}
