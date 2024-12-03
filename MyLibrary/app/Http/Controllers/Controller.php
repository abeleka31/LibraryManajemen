<?php

namespace App\Http\Controllers;

use App\Models\User;

abstract class Controller
{
    public function index()
    {
        $users = User::whereHas('roles', function($query) {
            $query->where('name', 'staff'); // Atau nama role yang diinginkan
        })->get();

        return view('dashboard.admin.index', compact('users'));
    }
    
}
