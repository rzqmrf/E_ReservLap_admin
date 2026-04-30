<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        return response()->json(Schedule::with('field')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'field_id'    => 'required|exists:fields,id',
            'day_of_week' => 'required|string',
            'open_time'   => 'required',
            'close_time'  => 'required',
            'is_open'     => 'boolean',
        ]);

        $schedule = Schedule::create($request->all());
        return response()->json($schedule, 201);
    }

    public function show($id)
    {
        $schedule = Schedule::with('field')->findOrFail($id);
        return response()->json($schedule);
    }

    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->update($request->all());
        return response()->json($schedule);
    }

    public function destroy($id)
    {
        Schedule::findOrFail($id)->delete();
        return response()->json(['message' => 'Schedule berhasil dihapus']);
    }

    // Ambil semua jadwal berdasarkan field
    public function byField($fieldId)
    {
        $schedules = Schedule::where('field_id', $fieldId)->get();
        return response()->json($schedules);
    }
}
