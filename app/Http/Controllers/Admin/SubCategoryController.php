<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use App\Models\Category;
use App\Models\Metadata;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subCategories = SubCategory::with(['category', 'metadata'])->get();
        return view('admin.subcategories.index', compact('subCategories'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.subcategories.create', compact('categories'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'meta_title' => 'required|string|max:255',
            'meta_description' => 'required|string',
            'meta_keywords' => 'required|string',
        ]);


        // Create metadata dynamically
        $metadata = Metadata::create([
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'slug' => Str::slug($request->meta_title),
        ]);


        // Create the subcategory with the linked metadata
        SubCategory::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'metadata_id' => $metadata->id,
        ]);


        return redirect()->route('subcategories.index')->with('success', 'SubCategory created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subCategory = SubCategory::with('metadata')->findOrFail($id);
        $categories = Category::all();
        return view('subcategories.edit', compact('subCategory', 'categories'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $metadata = $subCategory->metadata;


        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'meta_title' => 'required|string|max:255',
            'meta_description' => 'required|string',
            'meta_keywords' => 'required|string',
        ]);


        // Update metadata with the provided values
        $metadata->update([
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'slug' => Str::slug($request->meta_title),
        ]);


        // Update the subcategory
        $subCategory->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('subcategories.index')->with('success', 'SubCategory updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $subCategory->delete();

        return redirect()->route('subcategories.index')->with('success', 'SubCategory deleted successfully.');
    }
}



