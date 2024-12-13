<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Metadata;
use Illuminate\Http\Request;


class MetadataController extends Controller
{
    public function index()
    {
        $metadata = Metadata::all();
        return view('admin.metadata.index', compact('metadata'));
    }


    public function create()
    {
        return view('admin.metadata.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'meta_title' => 'required|string|max:60',
            'meta_description' => 'required|string|max:160',
            'meta_keywords' => 'required|string',
            'slug' => 'required|string|max:60|unique:metadata',
        ]);
   
        // Split meta_keywords by commas, trim spaces, and convert to JSON array
        $metaKeywordsArray = array_map('trim', explode(',', $request->meta_keywords));
        $requestData = $request->all();
        $requestData['meta_keywords'] = json_encode($metaKeywordsArray);
   
        Metadata::create($requestData);
   
        return redirect()->route('metadata.index')->with('success', 'Metadata created successfully.');
    }
   
    public function edit(Metadata $metadata)
    {
        // Decode JSON array and convert to a comma-separated string for display
        $keywords = json_decode($metadata->meta_keywords, true);
        if (!is_array($keywords)) {
            $keywords = [];
        }
        $metadata->meta_keywords = implode(',', $keywords);


        return view('admin.metadata.update', compact('metadata'));
    }


    public function update(Request $request, $id)
    {
        $metadata = Metadata::findOrFail($id);


        $request->validate([
            'meta_title' => 'required|string|max:60',
            'meta_description' => 'required|string|max:160',
            'meta_keywords' => 'nullable|string',
            'slug' => 'required|string|max:60|unique:metadata,slug,' . $metadata->id,
        ]);


        // Split meta_keywords by commas, trim spaces, and convert to JSON array
        $metaKeywordsArray = array_map('trim', explode(',', $request->meta_keywords));
        $requestData = $request->all();
        $requestData['meta_keywords'] = json_encode($metaKeywordsArray);


        $metadata->update($requestData);


        return redirect()->route('metadata.index')->with('success', 'Metadata updated successfully!');
    }


    public function destroy(Metadata $metadata)
    {
        $metadata->delete();
        return redirect()->route('metadata.index')->with('success', 'Metadata deleted successfully.');
    }
}



