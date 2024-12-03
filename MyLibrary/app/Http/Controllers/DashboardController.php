<?php

namespace App\Http\Controllers;

use App\Models\Book\Book;
class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil jumlah buku dari database
        $bookCount = Book::count();

        // Menampilkan dashboard dengan jumlah buku
        return view('Books.book.index', compact('bookCount'));
    }
}
