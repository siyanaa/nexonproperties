<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Metadata;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('metadata')->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'meta_keywords' => 'required|string|max:255',
        ]);

        // Create metadata dynamically based on category title
        $metaKeywordsArray = array_map('trim', explode(',', $request->keywords));
        $metadata = Metadata::create([
            'meta_title' => $request->title,
            'meta_description' => "Description for " . $request->title,
            'meta_keywords' => json_encode($metaKeywordsArray),
            'slug' => Str::slug($request->title),
        ]);

        // Create the category with the linked metadata
        Category::create([
            'title' => $request->title,
            'metadata_id' => $metadata->id,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::with('metadata')->findOrFail($id);
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::with('metadata')->findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);
        $metadata = $category->metadata;

        $request->validate([
            'title' => 'required|string|max:255',
            'meta_keywords' => 'required|string|max:255',
        ]);

        // Update metadata with the updated title and other fields
        $metaKeywordsArray = array_map('trim', explode(',', $request->keywords));
        $metadata->update([
            'meta_title' => $request->title,
            'meta_description' => "Description for " . $request->title,
            'meta_keywords' =>json_encode($metaKeywordsArray),
            'slug' => Str::slug($request->title),
        ]);

        // Update the category
        $category->update([
            'title' => $request->title,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
