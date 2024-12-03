<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Models\Book\Book;
use App\Models\Book\category;
use App\Models\Book\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('subCategory')->get();
        $subCategories = SubCategory::all();
        $categories = Category::all();

        return view('Books.book.index', compact('books', 'subCategories', 'categories'));
    }



    public function create()
    {
        // Ambil semua sub kategori untuk dropdown di form
        $subCategories = SubCategory::all();
        return view('Books.book.create', compact('subCategories'));
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string',
            'penulis' => 'required|string',
            'penerbit' => 'required|string',
            'tahunTerbit' => 'required|integer',
            'ISBN' => 'required|integer',
            'description' => 'required|string',
            'subcategory_id' => 'required|exists:sub_categories,id',
            'jumlahStock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg', // Validasi gambar
        ]);

        if($request->file('image')){
            $validatedData['image'] = $request->file('image')->store('book-imagge');
        }



        Book::create($validatedData);

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }
    public function edit(Book $book)
    {
        // Ambil semua sub kategori untuk dropdown di form
        $subCategories = SubCategory::all();
        return view('Books.book.edit', compact('book', 'subCategories'));
    }

    public function update(Request $request, Book $book)
    {
        // Validasi data yang dikirim dari form
        $validatedData = $request->validate([
            'name' => 'required|string',
            'penulis' => 'required|string',
            'penerbit' => 'required|string',
            'tahunTerbit' => 'required|integer',
            'ISBN' => 'required|integer',
            'description' => 'required|string',
            'subcategory_id' => 'required|exists:sub_categories,id',
            'jumlahStock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg', // Validasi gambar
        ]);

        // Periksa jika ada gambar baru yang diunggah
        if ($request->file('image')) {
            // Hapus gambar lama jika ada
            if ($book->image) {
                Storage::delete($book->image);
            }

            // Simpan gambar baru dan tambahkan ke data
            $validatedData['image'] = $request->file('image')->store('book-image');
        }

        // Update buku dengan data yang telah divalidasi
        $book->update($validatedData);

        // Redirect kembali ke daftar buku dengan pesan sukses
        return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui');
    }
    public function show(Book $book)
    {
        $subCategories = SubCategory::all();
        return view('Books.book.show', compact('book', 'subCategories'));
    }



    public function destroy(Book $book)
    {
        // Hapus gambar jika ada
        if ($book->image) {
            Storage::delete($book->image);
        }

        // Hapus buku dari database
        $book->delete();

        // Redirect ke halaman daftar buku dengan pesan sukses
        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus');
    }
}
