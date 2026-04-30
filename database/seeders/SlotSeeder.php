<?php

namespace Database\Seeders;

use App\Models\Field;
use App\Models\Slot;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SlotSeeder extends Seeder
{
    public function run(): void
    {
        $fields = Field::all();
        $startDate = Carbon::today();

        foreach ($fields as $field) {
            // Buat slot untuk 7 hari ke depan
            for ($i = 0; $i < 7; $i++) {
                $date = $startDate->copy()->addDays($i);
                
                // Buat beberapa slot waktu per hari (misal jam 08:00 - 22:00 dengan durasi 1 jam)
                for ($hour = 8; $hour < 22; $hour++) {
                    Slot::create([
                        'field_id' => $field->id,
                        'date' => $date->format('Y-m-d'),
                        'start_time' => sprintf('%02d:00:00', $hour),
                        'end_time' => sprintf('%02d:00:00', $hour + 1),
                        'capacity' => $field->capacity,
                        'booked_count' => 0,
                        'is_available' => true,
                    ]);
                }
            }
        }
    }
}
