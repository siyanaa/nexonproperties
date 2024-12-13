<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Amenity;
use App\Models\Metadata;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PropertyController extends Controller
{
    /**
     * Display a listing of the properties.
     */
    public function index()
    {
        $properties = Property::with('metadata', 'category', 'subCategory')->latest()->get();
        return view('admin.property.index', compact('properties'));
    }

    /**
     * Show the form for creating a new property.
     */
    public function create()
    {
        $categories = Category::all();
        $subCategories = SubCategory::all();
        $addresses = Address::all();
        $metadata = Metadata::all();
        $amenities = Amenity::all();  
        return view('admin.property.create', compact('categories', 'subCategories', 'metadata', 'amenities', 'addresses'));
    }

    /**
     * Store a newly created property in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'main_image' => 'required|array',
            'main_image.*' => 'required|string',
            'cropData' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'amenities' => 'required|array',
            'amenities.*' => 'exists:amenities,id',
            'street' => 'required|string|max:255',
            // 'suburb' => 'required|string|max:255',
            // 'state' => 'nullable|string|max:255',
            // 'post_code' => 'required|string|max:20',
            // 'country' => 'nullable|string|max:255',
            'address_id' => 'required|exists:addresses,id', // Validate the address_id
            'price' => 'required|numeric',
            'price_type' => 'required|in:fixed,negotiable,on_request',
            'bedrooms' => 'required|integer',
            'bathrooms' => 'required|integer',
            'area' => 'required|integer',
            'status' => 'required|boolean',
            'availability_status' => 'required|in:available,sold,rental',
            'rental_period' => 'nullable|string',
            'keywords' => 'nullable|string',
            'other_images' => 'nullable|array',
            'other_images.*' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'update_time' => 'nullable',
        ]);

        // Handle the main image upload (base64 images)
        $images = $this->handleBase64Images($request->input('main_image'), 'property');

        // Handle other images upload
        $otherImages = $this->handleUploadedImages($request->file('other_images'), 'property/other_images');

        // Create a metadata entry
        $metaKeywordsArray = array_map('trim', explode(',', $request->keywords));
        $metadata = Metadata::create([
            'meta_title' => $request->title,
            'meta_description' => $request->description,
            'meta_keywords' => json_encode($metaKeywordsArray),
            'slug' => Str::slug($request->title),
        ]);

        // Create new property record and associate with metadata
        Property::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'amenities' => $request->amenities,
            'street' => $request->street,
            // 'suburb' => $request->suburb,
            // 'state' => $request->state,
            // 'post_code' => $request->post_code,
            // 'country' => $request->country,
            'address_id' => $request->address_id, // Link the property to the selected address
            'price' => $request->price,
            'price_type' => $request->price_type,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'area' => $request->area,
            'status' => $request->status,
            'main_image' => json_encode($images),
            'other_images' => json_encode($otherImages),
            'availability_status' => $request->availability_status,
            'rental_period' => $request->rental_period,
            'metadata_id' => $metadata->id,
            'update_time' => $request->input('update_time'),
        ]);

        session()->flash('success', 'Property created successfully.');
        return redirect()->route('property.index');
    }

    /**
     * Display the specified property.
     */
    public function show(Property $property)
    {
        return view('admin.property.show', compact('property'));
    }

    /**
     * Show the form for editing the specified property.
     */
    public function edit(Property $property)
    {
        $categories = Category::all();
        $subCategories = SubCategory::all();
        $amenities = Amenity::all();
        $metadata = Metadata::all();

        return view('admin.property.update', compact('property', 'categories', 'subCategories', 'amenities', 'metadata'));
    }

    /**
     * Update the specified property in storage.
     */
    public function update(Request $request, Property $property)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'main_image' => 'nullable|array',
            'main_image.*' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'amenities' => 'required|array',
            'amenities.*' => 'exists:amenities,id',
            'street' => 'required|string|max:255',
            'suburb' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'post_code' => 'required|string|max:20',
            'country' => 'nullable|string|max:255',
            'price' => 'required|numeric',
            'price_type' => 'required|in:fixed,negotiable,on_request',
            'bedrooms' => 'required|integer',
            'bathrooms' => 'required|integer',
            'area' => 'required|integer',
            'status' => 'required|boolean',
            'availability_status' => 'required|in:available,sold,rental',
            'rental_period' => 'nullable|string',
            'keywords' => 'nullable|string',
            'other_images' => 'nullable|array',
            'other_images.*' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'update_time' => 'required|date_format:Y-m-d H:i:s',
        ]);

        // Handle main image update if provided
        if ($request->has('main_image')) {
            $this->deleteImages(json_decode($property->main_image, true), 'property/');
            $images = $this->handleBase64Images($request->input('main_image'), 'property');
        } else {
            $images = json_decode($property->main_image, true);
        }

        // Handle other images update if provided
        if ($request->hasFile('other_images')) {
            $this->deleteImages(json_decode($property->other_images, true), 'property/other_images/');
            $otherImages = $this->handleUploadedImages($request->file('other_images'), 'property/other_images');
        } else {
            $otherImages = json_decode($property->other_images, true);
        }

        // Update metadata record
        $property->metadata()->updateOrCreate([], [
            'meta_title' => $request->title,
            'meta_description' => $request->description,
            'meta_keywords' => $request->suburb,
            'slug' => Str::slug($request->title),
        ]);

        // Update the property record
        $property->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'amenities' => $request->amenities,
            'street' => $request->street,
            'suburb' => $request->suburb,
            'state' => $request->state,
            'post_code' => $request->post_code,
            'country' => $request->country,
            'price' => $request->price,
            'price_type' => $request->price_type,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'area' => $request->area,
            'status' => $request->status,
            'other_images' => json_encode($otherImages),
            'availability_status' => $request->availability_status,
            'rental_period' => $request->rental_period,
            'update_time' => $request->input('update_time'),
        ]);

        session()->flash('success', 'Property updated successfully.');
        return redirect()->route('property.index');
    }

    /**
     * Handle base64 image uploads and convert them to WEBP.
     */
    private function handleBase64Images(array $base64Images, $folder, $existingImages = [])
    {
        // Initialize with existing images if provided
        $images = !empty($existingImages) ? $existingImages : [];

        foreach ($base64Images as $base64Image) {
            // Extract base64 encoded part and decode it
            $image = explode(',', $base64Image);
            if (isset($image[1])) {
                $decodedImage = base64_decode($image[1]);
            } else {
                continue; // Skip if the base64 string is not properly formatted
            }
            $imageResource = imagecreatefromstring($decodedImage);

            if ($imageResource !== false) {
                // Generate unique image name
                $imageName = time() . '-' . Str::uuid() . '.webp';
                // Correct destination path
                // $destinationPath = storage_path("app/public/$folder");

                //To save the data in the public folder inside the storage
                $destinationPath = public_path("storage/$folder");

                // Create the directory if it does not exist
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true, true);
                }

                // Save the image in WEBP format
                $savedPath = $destinationPath . '/' . $imageName;
                imagewebp($imageResource, $savedPath);
                imagedestroy($imageResource);

                // Correctly formatted relative path for storage link
                $relativeImagePath = "storage/$folder/$imageName";
                $images[] = $relativeImagePath;
            }
        }

        return $images;
    }

    /**
     * Handle uploaded image files and convert them to WEBP.
     */
    private function handleUploadedImages($uploadedFiles, $folder, $existingImages = [])
    {
        // Initialize with existing images if any
        $images = !empty($existingImages) ? $existingImages : [];

        if ($uploadedFiles) {
            foreach ($uploadedFiles as $file) {
                // Generate a unique name for each image
                $imageName = time() . '-' . Str::uuid() . '.webp';
                // Correct destination path for storage
                // $destinationPath = storage_path("app/public/$folder");

                //To save the data inside public folder
                $destinationPath = public_path("storage/$folder");

                // Create the directory if it does not exist
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true, true);
                }

                // Convert the uploaded image to WEBP format
                $imageResource = imagecreatefromstring(file_get_contents($file));
                $savedPath = $destinationPath . '/' . $imageName;
                imagewebp($imageResource, $savedPath);
                imagedestroy($imageResource);

                // Correctly formatted relative path for storage link
                $relativeImagePath = "storage/$folder/$imageName";
                $images[] = $relativeImagePath;
            }
        }

        return $images;
    }

    /**
     * Remove the specified property from storage.
     */
    public function destroy(Property $property)
    {
        // Delete main images
        $this->deleteImages(json_decode($property->main_image, true), 'property/');

        // Delete other images
        $this->deleteImages(json_decode($property->other_images, true), 'property/other_images/');

        // Delete the property from the database
        $property->delete();

        return redirect()->route('property.index')->with('success', 'Property deleted successfully.');
    }

    /**
     * Deletes images from the specified path.
     *
     * @param array|string|null $images
     * @param string $folderPath
     */
    private function deleteImages($images, $folderPath)
    {
        // If $images is a string, convert it to an array
        if (is_string($images)) {
            $images = [$images];
        }

        // If $images is an array, iterate through each image
        if (is_array($images)) {
            foreach ($images as $image) {
                // Check if image is not empty
                if (!empty($image)) {
                    // Extract the basename of the image path
                    $imagePath = storage_path('app/public/' . $folderPath . basename($image));

                    // Check if the image exists and delete it
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
            }
        }
    }

    /**
     * Update images for the specified property.
     */
    public function updateImages(Request $request, $id)
{
    $request->validate([
        'main_image_base64' => 'nullable|string',
        'other_images.*' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $property = Property::findOrFail($id);

    // Handle main image update if provided
    if ($request->has('main_image_base64')) {
        $mainImageData = $request->input('main_image_base64');
        
        // Remove the data:image part and decode the image
        $mainImage = preg_replace('/^data:image\/\w+;base64,/', '', $mainImageData);
        $mainImage = base64_decode($mainImage);
        
        // Generate a unique filename
        $filename = 'main_' . time() . '.webp';
        $path = 'property/' . $filename;
        
        // Save the image
        Storage::disk('public')->put($path, $mainImage);
        
        // Update the property's main_image field
        $property->main_image = json_encode([$path]);
    }

    // Handle other images update
    if ($request->hasFile('other_images')) {
        // Delete existing other images
        $this->deleteImages(json_decode($property->other_images, true), 'property/other_images/');
        // Handle new other images
        $otherImages = $this->handleUploadedImages($request->file('other_images'), 'property/other_images');
        $property->other_images = json_encode($otherImages);
    }

    $property->save();

    return redirect()->route('property.index')->with('success', 'Images updated successfully.');
}
}