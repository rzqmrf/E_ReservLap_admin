<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'booking_code',
        'user_id',
        'field_id',
        'slot_id',       
        'date',
        'start_time',
        'end_time',
        'duration_hours',
        'total_price',
        'person_count',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // tambah ini
    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }
}
