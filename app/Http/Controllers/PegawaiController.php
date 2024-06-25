<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PegawaiController extends Controller
{
    public function index()
    {
        $users = User::orderBy("name", "asc")->get();
        $data['employees'] = $users;
        return view('pages.pegawai.index', $data);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:pegawai,email',
            'phone_number' => 'nullable|string|max:15',
            'password' => 'required|string|min:8',
            'alamat' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $pegawai = new User($validatedData);
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $pegawai->avatar = $path;
        }
        $pegawai->save();

        return response()->json(['message' => 'Pegawai created successfully'], 201);
    }
    public function show($id)
    {
        $pegawai = User::findOrFail($id);
        return response()->json($pegawai, 200);
    }
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255'
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email,' . $user->id
            ],
            'password' => [
                'nullable',
                'min:8'
            ],
            'phone_number' => [
                'nullable',
                'string',
                'max:15'
            ],
            'alamat' => [
                'nullable',
                'string'
            ],
            'avatar' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048'
            ],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone_number = $validated['phone_number'] ?? $user->phone_number;
        $user->alamat = $validated['alamat'] ?? $user->alamat;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        if ($request->hasFile('avatar')) {
            // Delete the old avatar if it exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            // Store the new avatar
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return response()->json([
            'message' => 'Berhasil mengubah data User',
            'data' => $user
        ], 200);
    }


    public function destroy($id)
    {
        $pegawai = User::findOrFail($id);

        // Delete avatar if exists
        if ($pegawai->avatar) {
            Storage::disk('public')->delete($pegawai->avatar);
        }

        $pegawai->delete();

        return response()->json(['message' => 'Pegawai deleted successfully'], 200);
    }

}
