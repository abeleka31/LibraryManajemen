<?php
namespace App\Http\Controllers;

use App\Models\Book\Book;
use App\Models\Book\category;
use App\Models\Book\SubCategory;
use App\Models\Loan;
use App\Models\Mahasiswa;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = User::where('id', Auth::user()->id)->first();
        if (!Auth::check()) {
            return redirect('login');
        }

        $staffCount = Staff::count();
        $mahasiswaCount = Mahasiswa::count();
        $bookCount = Book::count();
        $admins = User::where('role', 'admin')->get();

        $books = Book::with('subCategory')->get(); // Eager loading untuk subCategory
        $subCategories = SubCategory::all();
        $categories = category::all();

        $adminName = Auth::user()->name;
        $mahasiswaName = Auth::user()->name;
        $staffs = Auth::user()->staff;
        $loans = Loan::with('book')->whereIn('status', ['pengajuan pengembalian', 'pengajuan'])->get();
        $countPendingReturns = $loans->count();

        $loanse = Loan::with(['Mahasiswa', 'Book'])->get();
        $mahasiswase = Mahasiswa::all();
        $bookse = Book::all();


        switch (Auth::user()->role) {
            case 'admin':
                return view('dashboard.admin.home', compact('adminName', 'staffCount', 'mahasiswaCount', 'bookCount', 'admins', 'loanse', 'mahasiswase', 'bookse' ));
            case 'staff':
                return view('dashboard.staff.home', compact('staffs', 'countPendingReturns'));
            default:
                return view('dashboard.mahasiswa.home', compact('mahasiswaName','books', 'subCategories', 'categories'));
        }
    }
}
