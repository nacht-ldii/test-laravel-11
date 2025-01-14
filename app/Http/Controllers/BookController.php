<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class BookController extends Controller
{
    public function index()
    {
        return view('layouts.table-example');
    }

    public function fetchBooks()
    {
        $books = Book::with('category')->get();
        return response()->json(['data' => $books]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'kategori_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $data = $request->only(['judul', 'penulis', 'kategori_id']);
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('img/books'), $imageName); // Simpan ke folder public/img/books
            $data['image'] = 'img/books/' . $imageName;
        }
    
        $book = Book::create($data);
    
        return response()->json(['success' => true, 'data' => $book]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'kategori_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $book = Book::findOrFail($id);
    
        $data = $request->only(['judul', 'penulis', 'kategori_id']);
    
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($book->image && file_exists(public_path($book->image))) {
                unlink(public_path($book->image));
            }
    
            // Simpan gambar baru
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('img/books'), $imageName);
            $data['image'] = 'img/books/' . $imageName;
        }
    
        $book->update($data);
    
        return response()->json(['success' => true, 'message' => 'Book updated successfully']);
    }
        
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
    
        // Hapus gambar jika ada
        if ($book->image && file_exists(public_path($book->image))) {
            unlink(public_path($book->image));
        }
    
        $book->delete();
    
        return response()->json(['success' => true, 'message' => 'Book deleted successfully']);
    }
    }
