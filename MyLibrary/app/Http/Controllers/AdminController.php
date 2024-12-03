<?php

namespace App\Http\Controllers;

use App\Models\Book\Book;
use App\Models\Loan;
use App\Models\Mahasiswa;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $staffCount = Staff::count();
        $mahasiswaCount = Mahasiswa::count();
        $bookCount = Book::count();
        $admins = User::where('role', 'admin')->get();
        return view('dashboard.admin.home', compact('bookCount', 'mahasiswaCount', 'staffCount'));
    }


    public function profile()
    {
        $user = User::where('id', Auth::user()->id)->first();
        return view('dashboard.admin.profile', compact('user'));
    }

    public function daftarStaff(){
        $staffs = Staff::with('user')->get();
        return view('dashboard.admin.daftarStaff', compact('staffs'));
    }

    public function daftarMahasiswa()
    {
        $mahasiswa = Mahasiswa::with('user')->get();
        return view('dashboard.admin.daftarMahasiswa', compact('mahasiswa'));
    }

    public function daftarPinjaman()
    {
        $loans = Loan::with(['Mahasiswa', 'Book'])->get();
        $mahasiswas = Mahasiswa::all();
        $books = Book::all();
        

    }
}
