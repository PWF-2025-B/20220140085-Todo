<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Models\Todo2;


class CategoryController extends Controller
{
    // Tampilkan semua kategori milik user login
    public function index()
    {
        $categories = Category::withCount('todos')
                        ->where('user_id', Auth::id())
                        ->get();

        return view('categories.index', compact('categories'));
    }

    // Tampilkan form tambah kategori
    public function create()
    {
        return view('categories.create');
    }

    // Simpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255'
        ]);

        Category::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created.');
    }

    // Tampilkan form edit
    public function edit(Category $category)
    {
        // Pastikan hanya pemilik yang bisa edit
        if ($category->user_id != Auth::id()) {
            abort(403);
        }

        return view('categories.edit', compact('category'));
    }

    // Update kategori
    public function update(Request $request, Category $category)
    {
        if ($category->user_id != Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255'
        ]);

        $category->update([
            'title' => $request->title,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated.');
    }

    // Hapus kategori
    public function destroy(Category $category)
    {
        if ($category->user_id != Auth::id()) {
            abort(403);
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted.');
    }
}
