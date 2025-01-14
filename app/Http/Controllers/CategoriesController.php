<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        return view('layouts.categories');
    }

    public function fetchCategories()
    {
        $categories = Categories::all();
        return response()->json(['data' => $categories]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
        ]);

        $category = Categories::create($request->all());
        return response()->json(['success' => true, 'data' => $category]);
    }
    public function update(Request $request, $id)
    {
        $categorie = Categories::findOrFail($id);
        $categorie->update($request->only(['name']));

        return response()->json(['success' => true, 'message' => 'Categories updated successfully']);
    }

    public function destroy($id)
    {
        $categorie = Categories::findOrFail($id);
        $categorie->delete();

        return response()->json(['success' => true, 'message' => 'Categories deleted successfully']);
    }
}
