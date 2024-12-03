<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Models\Book\Book;
use App\Models\Book\SubCategory;
use Illuminate\Http\Request;

class BookShowController extends Controller
{
    public function show($id)
    {
        $book = Book::with('subCategory')->findOrFail($id); // Ambil data buku dengan relasi sub kategori

        return view('dashboard.mahasiswa.detailBook', compact('book')); // Mengarahkan ke view detailBook
    }
}
