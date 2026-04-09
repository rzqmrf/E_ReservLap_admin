<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Field;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FieldController extends Controller
{
    public function index()
    {
    return response()->json(
        Field::all(['id', 'name', 'type', 'price', 'status', 'description'])
    );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|string|max:100',
            'price'       => 'required|numeric|min:0',
            'status'      => ['required', Rule::in(['available', 'unavailable'])],
            'description' => 'nullable|string',
        ]);

        $field = Field::create($validated);

        return response()->json($field, 201);
    }

    public function update(Request $request, $id)
    {
        $field = Field::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|string|max:100',
            'price'       => 'required|numeric|min:0',
            'status'      => ['required', Rule::in(['available', 'unavailable'])],
            'description' => 'nullable|string',
        ]);

        $field->update($validated);

        return response()->json($field);
    }

    public function destroy($id)
    {
        $field = Field::findOrFail($id);
        $field->delete();

        return response()->json(['message' => 'Lapangan berhasil dihapus']);
    }
}
