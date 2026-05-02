<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class FieldController extends Controller
{
    public function index()
    {
        return response()->json(
            Field::all(['id', 'name', 'foto_lapangan', 'type', 'price', 'capacity', 'status', 'description'])
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'foto_lapangan' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'type'          => 'required|string|max:100',
            'price'         => 'required|numeric|min:0',
            'status'        => ['required', Rule::in(['available', 'unavailable'])],
            'description'   => 'nullable|string',
        ]);

        if ($request->hasFile('foto_lapangan')) {
            $path = $request->file('foto_lapangan')->store('fields', 'public');
            $validated['foto_lapangan'] = $path;
        }

        $field = Field::create($validated);

        return response()->json($field, 201);
    }

    public function update(Request $request, $id)
    {
        $field = Field::findOrFail($id);

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'foto_lapangan' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'type'          => 'required|string|max:100',
            'price'         => 'required|numeric|min:0',
            'status'        => ['required', Rule::in(['available', 'unavailable'])],
            'description'   => 'nullable|string',
        ]);

        if ($request->hasFile('foto_lapangan')) {
            // Hapus foto lama jika ada
            if ($field->foto_lapangan) {
                Storage::disk('public')->delete($field->foto_lapangan);
            }
            $path = $request->file('foto_lapangan')->store('fields', 'public');
            $validated['foto_lapangan'] = $path;
        } else {
            // Jangan overwrite foto lama jika tidak ada file baru
            unset($validated['foto_lapangan']);
        }

        $field->update($validated);

        return response()->json($field->fresh());
    }

    public function destroy($id)
    {
        $field = Field::findOrFail($id);

        // Hapus foto dari storage
        if ($field->foto_lapangan) {
            Storage::disk('public')->delete($field->foto_lapangan);
        }

        $field->delete();

        return response()->json(['message' => 'Lapangan berhasil dihapus']);
    }
}
