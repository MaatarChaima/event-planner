<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryCMController extends Controller
{
    // 📄 LIST
    public function index()
    {
        return response()->json(
            Category::orderBy('name')->get(),
            200
        );
    }

    // ➕ CREATE
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
        ]);

        $category = Category::create($validated);

        return response()->json($category, 201);
    }

    // 🔍 SHOW
    public function show(Category $category)
    {
        return response()->json($category, 200);
    }

    // ✏️ UPDATE
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $category->id],
        ]);

        $category->update($validated);

        return response()->json($category, 200);
    }

    // ❌ DELETE
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'message' => 'Catégorie supprimée avec succès'
        ], 200);
    }
}
