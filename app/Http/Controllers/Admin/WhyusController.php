<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Whyus;
use App\Models\Metadata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Cviebrock\EloquentSluggable\Services\SlugService;

class WhyusController extends Controller
{
    /**
     * Display a listing of the whyus.
     */
    public function index()
    {
        $WhyUs = Whyus::with('metadata')->latest()->get();
        return view('admin.whyus.index', compact('WhyUs'));
    }

    /**
     * Show the form for creating a new WhyUs.
     */
    public function create()
    {
        $metadata = Metadata::all();
        return view('admin.whyus.create', compact('metadata'));
    }

    /**
     * Store a newly created WhyUs in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'keywords' => 'nullable|string',
            'image' => 'required|array',
            'image.*' => 'required|string', // Validate as string since it's base64
            'status' => 'required|boolean',
            'cropData' => 'required|string',
        ]);

        $cropData = json_decode($request->input('cropData'), true);
        $images = [];

        foreach ($request->input('image') as $base64Image) {
            $image = explode(',', $base64Image);
            $decodedImage = base64_decode($image[1]);
            $imageResource = imagecreatefromstring($decodedImage);

            if ($imageResource !== false) {
                $imageName = time() . '-' . Str::uuid() . '.webp';
                $destinationPath = public_path('storage/whyus');

                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true, true);
                }

                $savedPath = $destinationPath . '/' . $imageName;
                imagewebp($imageResource, $savedPath);
                imagedestroy($imageResource);
                $relativeImagePath = 'storage/whyus/' . $imageName;
                $images[] = $relativeImagePath;
            }
        }

        // Create a new metadata entry
        $metaKeywordsArray = array_map('trim', explode(',', $request->keywords));
        $metadata = Metadata::create([
            'meta_title' => $request->title,
            'meta_description' => $request->description,
            'meta_keywords' => json_encode($metaKeywordsArray),
            'slug' => Str::slug($request->title)
        ]);

        // Create new whyus record and associate with metadata
        Whyus::create([
            'title' => $request->title,
            'description' => $request->description,
            'keywords' => $request->keywords,
            'image' => json_encode($images),
            'status' => $request->status,
            'metadata_id' => $metadata->id, // Link newly created metadata
        ]);

        session()->flash('success', 'WhyUs created successfully.');

        return redirect()->route('whyus.index');
    }

    /**
     * Show the form for editing the specified whyus
     */
    public function edit($id)
    {
        $WhyUs = Whyus::findOrFail($id); 
        return view('admin.whyus.update', compact('WhyUs'));
    }

    /**
     * Update the specified whyus in storage.
     */
    public function update(Request $request, $id)
    {
        $WhyUs = Whyus::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'keywords' => 'nullable|string',
            'croppedImage' => 'sometimes|string',
            'status' => 'required|boolean',
            'cropData' => 'sometimes|string',
        ]);

        $cropData = $request->input('cropData') ? json_decode($request->input('cropData'), true) : null;
        $images = $WhyUs->image ? json_decode($WhyUs->image, true) : [];
        
        // Handle new image
        if ($request->has('croppedImage')) {
            $base64Image = $request->input('croppedImage');
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
                $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
                $decodedImage = base64_decode($base64Image);

                if ($decodedImage !== false) {
                    $imageType = strtolower($type[1]);
                    if (in_array($imageType, ['jpg', 'jpeg', 'gif', 'png', 'webp'])) {
                        $imageResource = imagecreatefromstring($decodedImage);
                        if ($imageResource !== false) {
                            $imageName = time() . '-' . Str::uuid() . '.webp';
                            $destinationPath = public_path('storage/whyus');

                            if (!File::exists($destinationPath)) {
                                File::makeDirectory($destinationPath, 0755, true, true);
                            }

                            $savedPath = $destinationPath . '/' . $imageName;
                            imagewebp($imageResource, $savedPath);
                            imagedestroy($imageResource);

                            $relativeImagePath = 'storage/whyus/' . $imageName;
                            $images[] = $relativeImagePath;  // Add new image to the array

                            // Delete old image if exists
                            if (!empty($images)) {
                                $oldImagePath = public_path('storage/whyus/' . $images[0]);
                                if (file_exists($oldImagePath)) {
                                    unlink($oldImagePath);
                                }
                                array_shift($images);  // Remove the old image from the array
                            }
                        }
                    }
                }
            }
        }

        // Update metadata
        $metaKeywordsArray = array_map('trim', explode(',', $request->keywords));
        $WhyUs->metadata()->updateOrCreate([], [
            'meta_title' => $request->title,
            'meta_description' => $request->description,
            'meta_keywords' => json_encode($metaKeywordsArray),
            'slug' => Str::slug($request->title)
        ]);

        // Update WhyUs record
        $WhyUs->update([
            'title' => $request->title,
            'description' => $request->description,
            'keywords' => $request->keywords,
            'image' => json_encode($images),  // Store as JSON string
            'status' => $request->status,
        ]);

        session()->flash('success', 'WhyUs updated successfully.');

        return redirect()->route('whyus.index');
    }
    /**
     * Remove the specified whyus from storage.
     */
    public function destroy(Whyus $WhyUs)
    {
        $images = json_decode($WhyUs->image, true);
        if ($images) {
            foreach ($images as $image) {
                $filePath = storage_path('app/' . $image);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        $WhyUs->delete();

        return redirect()->route('whyus.index')->with('success', 'WhyUs deleted successfully.');
    }
}
