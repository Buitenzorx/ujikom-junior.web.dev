<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = User::orderBy('name', 'asc') ->get();
        return response()->json([
            'message' => 'Berhasil Menampilkan data User',
            'data' => $users
        ], 200);    
    }
    public function store(Request $request){
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
        return response() ->json([
            'message' => 'Berhasil Menambahkan data User',
            'data' => $user
        ],201);
    }
    public function show(string $id){
        $user = User::find($id);
        return response() ->json([
            'message' => 'Berhasil menampilkan detail user',
            'data' => $user
        ],201);
    }
    public function update(Request $request, string $id){
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
                'unique:users,email'. $id
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
        return response() ->json([
            'message' => 'Berhasil mengubah data User',
            'data' => $user
        ],201);
    }
    
}
