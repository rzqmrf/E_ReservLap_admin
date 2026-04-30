<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // GET semua user
    public function index()
    {
        return response()->json(
            User::all(['id', 'name', 'email'])
        );
    }

    // POST tambah user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => bcrypt(Str::random(16)), // ✅ random, bukan '123456'
        ]);

        return response()->json($user, 201);
    }

    // PUT update user
    public function update(Request $request, $id)
    {
        // ✅ findOrFail otomatis return 404 kalau tidak ketemu
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            // ✅ ignore email milik user ini sendiri
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
        ]);

        $user->update($validated);

        return response()->json($user);
    }

    // DELETE user
    public function destroy($id)
    {
        // ✅ findOrFail otomatis return 404 kalau tidak ketemu
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User berhasil dihapus']);
    }
}
