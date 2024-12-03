<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Models\Book\category;
use GuzzleHttp\Exception\TooManyRedirectsException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories = category::all();
        return view('Books.categories.index', compact('categories'));
    }

    public function create(){
        $categories = category::all();
        return view('Books.categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:225',
        ]);

        category::create($request->all());
        return redirect()->route('category.index')->with('succes', 'Berhasil Membuat Category');
    }

    public function edit(category $category)
    {
        return view('Books.categories.edit');
    }

    public function update(Request $request, category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($request->all());
        return redirect()->route('category.index')->with('succes', 'Category Sukses di Update');
    }

    public function destroy(category $category)
    {
        $category->delete();
        return redirect()->route('category.index')->with('succes', 'category berhasil di hapus');
    }

}
