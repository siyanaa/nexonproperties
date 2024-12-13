<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Metadata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Display a listing of the services.
     */
    public function index()
    {
        $services = Service::with('metadata')->latest()->get();
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new service.
     */
    public function create()
    {
        $metadata = Metadata::all();
        return view('admin.services.create', compact('metadata'));
    }

    /**
     * Store a newly created service in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
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
                $destinationPath = storage_path('app/public/services');

                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true, true);
                }

                $savedPath = $destinationPath . '/' . $imageName;
                imagewebp($imageResource, $savedPath);
                imagedestroy($imageResource);
                $relativeImagePath = 'storage/services/' . $imageName;
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

        // Create new service record and associate with metadata
        Service::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'keywords' => $request->keywords,
            'image' => json_encode($images),
            'status' => $request->status,
            'metadata_id' => $metadata->id, // Link newly created metadata
        ]);

        session()->flash('success', 'Service created successfully.');

        return redirect()->route('services.index');
    }

    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified service.
     */
    public function edit(Service $service)
    {
        $metadata = Metadata::all();
        return view('admin.services.update', compact('service', 'metadata'));
    }

    /**
     * Update the specified service in storage.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string',
            'keywords' => 'nullable|string',
            'image' => 'nullable|array',
            'image.*' => 'nullable|string',
            'status' => 'required|boolean',
            'cropData' => 'nullable|string',
        ]);
    
        $images = !empty($service->image) ? json_decode($service->image, true) : [];
    
        if ($request->has('image') && is_array($request->image)) {
            foreach ($request->image as $base64Image) {
                if (is_string($base64Image) && preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
                    $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
                    $decodedImage = base64_decode($base64Image);
    
                    if ($decodedImage === false) {
                        continue;
                    }
    
                    $imageType = strtolower($type[1]);
                    if (!in_array($imageType, ['jpg', 'jpeg', 'gif', 'png', 'webp'])) {
                        continue;
                    }
    
                    $imageResource = imagecreatefromstring($decodedImage);
                    if ($imageResource !== false) {
                        $imageName = time() . '-' . Str::uuid() . '.webp';
                        $destinationPath = storage_path('app/public/services');
    
                        if (!File::exists($destinationPath)) {
                            File::makeDirectory($destinationPath, 0755, true, true);
                        }
    
                        $savedPath = $destinationPath . '/' . $imageName;
                        imagewebp($imageResource, $savedPath);
                        imagedestroy($imageResource);
    
                        $relativeImagePath = 'storage/services/' . $imageName;
                        $images[] = $relativeImagePath;
                    }
                }
            }
        }
        
        $metaKeywordsArray = array_map('trim', explode(',', $request->keywords));
        $metadata = Metadata::updateOrCreate(
            ['id' => $service->metadata_id],
            [
                'meta_title' => $request->title,
                'meta_description' => $request->description,
                'meta_keywords' => json_encode($metaKeywordsArray),
                'slug' => Str::slug($request->title)
            ]
        );
    
        $serviceData = [
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'keywords' => $request->keywords,
            'status' => $request->status,
            'metadata_id' => $metadata->id,
        ];
    
        if (!empty($images)) {
            $serviceData['image'] = json_encode($images);
        }
    
        $service->update($serviceData);
    
        return redirect()->route('services.index')
                         ->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified service from storage.
     */
    public function destroy(Service $service)
    {
        $images = json_decode($service->image, true);
        if ($images) {
            foreach ($images as $image) {
                $filePath = storage_path('app/' . $image);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }
}