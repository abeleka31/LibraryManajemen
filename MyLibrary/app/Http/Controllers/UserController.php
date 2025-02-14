<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('mahasiswa')->get();
        return view('dashboard.admin.daftarMahasiswa', compact('users'));
    }
}
