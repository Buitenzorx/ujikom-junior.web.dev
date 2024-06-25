<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name', 'asc')->get();
        return response()->json([
            'message' => 'Berhasil Menampilkan data User',
            'data' => $users
        ], 200);
    }
    public function store(Request $request)
    {
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
                'unique:users,email'
            ],
            'password' => [
                'required',
                'min:8'
            ],
            'phone_number' => [
                'nullable'
            ],
            'alamat' => [
                'nullable'
            ],
            'avatar' => [
                'nullable'
            ],
        ]);
        $user = User::create($validated);
        return response()->json([
            'message' => 'Berhasil Menambahkan data User',
            'data' => $user
        ], 201);
    }
    public function show(string $id)
    {
        $user = User::find($id);
        return response()->json([
            'message' => 'Berhasil menampilkan detail user',
            'data' => $user
        ], 201);
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
    $user->phone_number = $request->input('phone_number');
    $user->alamat = $request->input('alamat');

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
