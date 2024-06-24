<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index(){
        $users = User::orderBy("name","asc")->get();
        $data ['employees'] = $users;       
        return view('pages.pegawai.index', $data);
    }
}
