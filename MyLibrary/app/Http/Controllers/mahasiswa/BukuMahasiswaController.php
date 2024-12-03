<?php
namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Book\Book;
use App\Models\Book\Category;
use App\Models\Book\SubCategory;
use Illuminate\Http\Request;

class BukuMahasiswaController extends Controller
{
    public function index()
    {
        $books = Book::with('subCategory')->latest()->get(); // Ambil 5 buku terbaru
        $subCategories = SubCategory::all();
        $categories = Category::all();

        return view('dashboard.mahasiswa.home', compact('books', 'subCategories', 'categories'));
    }

    public function show($id)
    {
        $book = Book::with('subCategory')->findOrFail($id); // Ambil 5 buku terbaru
        $subCategories = SubCategory::all();
        $categories = Category::all();

        return view('dashboard.mahasiswa.show', compact('book', 'subCategories', 'categories'));
    }
    public function cariBuku()
    {
        $books = Book::with('subCategory')->latest()->get(); // Ambil 5 buku terbaru
        $subCategories = SubCategory::all();
        $categories = Category::all();

        return view('dashboard.mahasiswa.index', compact('books', 'subCategories', 'categories'));
    }
    public function landingPage()
    {
        return view('dashboard.mahasiswa.myLibrary');
    }
}

