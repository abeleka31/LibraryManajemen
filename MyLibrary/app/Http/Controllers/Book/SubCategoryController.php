<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Models\Book\Category;
use App\Models\Book\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index()
    {
        // Ambil sub kategori bersama dengan kategori yang terkait
        $subCategories = SubCategory::with('category')->get();
        $categories = Category::all(); 
        return view('Books.subCategories.index', compact('subCategories', 'categories'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id', // Pastikan category_id valid dan ada di tabel categories
        ]);

        // Simpan sub kategori
        SubCategory::create([
            'name' => $request->name,
            'category_id' => $request->category_id,  // Menyimpan category_id
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('subCategory.index')->with('success', 'SubCategory berhasil ditambahkan');
    }

    public function update(Request $request, SubCategory $subCategory)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id', // Pastikan category_id valid
        ]);

        // Update sub kategori
        $subCategory->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('subCategory.index')->with('success', 'SubCategory berhasil diupdate');
    }

    public function destroy(SubCategory $subCategory)
    {
        // Hapus sub kategori
        $subCategory->delete();
        return redirect()->route('subCategory.index')->with('success', 'SubCategory berhasil dihapus');
    }
}
