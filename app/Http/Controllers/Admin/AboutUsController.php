<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\Metadata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
class AboutUsController extends Controller
{
    /**
     * Display a listing of the aboutus.
     */
    public function index()
    {
        $aboutUs = AboutUs::with('metadata')->latest()->get();
        return view('admin.aboutus.index', compact('aboutUs'));
       
    }
    /**
     * Show the form for creating a new AboutUs.
     */
    public function create()
    {
        
        $metadata = Metadata::all();
        return view('admin.aboutus.create', compact('metadata'));
      
    }
    /**
     * Store a newly created AboutUs in storage.
     */
    
    
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'subtitle' => 'required|string|max:255',
        'description' => 'required|string',
        'keywords' => 'nullable|string',
        'status' => 'required|boolean',
        'cropData' => 'nullable|string',
    ]);

    // Handle base64 image processing
    $croppedImage = $request->input('croppedImage');
    $images = [];

    if ($croppedImage) {
        $base64Image = str_replace('data:image/png;base64,', '', $croppedImage);
        $base64Image = str_replace(' ', '+', $base64Image);
        $imageData = base64_decode($base64Image);

        $imageName = time() . '-' . Str::uuid() . '.webp';
        $destinationPath = public_path('storage/aboutus');

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true, true);
        }

        $savedPath = $destinationPath . '/' . $imageName;
        file_put_contents($savedPath, $imageData);

        $relativeImagePath = 'storage/aboutus/' . $imageName;
        $images[] = $relativeImagePath;
    }

    // Handle metadata
    $metaKeywordsArray = array_map('trim', explode(',', $request->keywords));
    $metadata = Metadata::create([
        'meta_title' => $request->title,
        'meta_description' => $request->description,
        'meta_keywords' => json_encode($metaKeywordsArray),
        'slug' => Str::slug($request->title),
    ]);

    AboutUs::create([
        'title' => $request->title,
        'subtitle' => $request->subtitle,
        'description' => $request->description,
        'keywords' => $request->keywords,
        'image' => json_encode($images),
        'status' => $request->status,
        'metadata_id' => $metadata->id,
    ]);

    session()->flash('success', 'About Us entry created successfully.');
    return redirect()->route('aboutus.index');
}


    

    /**
     * Show the form for editing the specified aboutus
     */
    public function edit($id)
    {
       
        $aboutUs = AboutUs::findOrFail($id);
        return view('admin.aboutus.update', compact('aboutUs'));
    }
    /**
     * Update the specified aboutus in storage.
     */
    public function update(Request $request, $id)
    {
        $aboutUs = AboutUs::findOrFail($id);
    
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string',
            'keywords' => 'nullable|string',
            'croppedImage' => 'nullable|string',
            'cropData' => 'nullable|string',
            'status' => 'required|boolean',
        ]);
    
        // Handle image processing
        $newImages = $this->handleImages($request->input('croppedImage'), $aboutUs->image);
    
        // Update or create metadata record
        $metaKeywordsArray = array_map('trim', explode(',', $request->keywords));
        $aboutUs->metadata()->updateOrCreate([], [
            'meta_title' => $request->title,
            'meta_description' => $request->description,
            'meta_keywords' => json_encode($metaKeywordsArray),
            'slug' => Str::slug($request->title),
        ]);
    
        // Update AboutUs record
        $aboutUs->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'keywords' => $request->keywords,
            'image' => json_encode($newImages),
            'status' => $request->status,
        ]);
    
        session()->flash('success', 'AboutUs updated successfully.');
        return redirect()->route('aboutus.index');
    }
    
    /**
     * Handle the processing of images.
     *
     * @param string|null $croppedImage
     * @param string|null $currentImageJson
     * @return array
     */
    protected function handleImages($croppedImage, $currentImageJson)
    {
        $currentImages = is_string($currentImageJson) ? json_decode($currentImageJson, true) : [];
        $newImages = [];
    
        if ($croppedImage) {
            $croppedImages = json_decode($croppedImage, true);
            foreach ($croppedImages as $base64Image) {
                $imagePath = $this->saveBase64Image($base64Image);
                if ($imagePath) {
                    $newImages[] = $imagePath;
                }
            }
    
            // Delete old images
            foreach ($currentImages as $oldImage) {
                $this->deleteImage($oldImage);
            }
        }
    
        return $newImages;
    }
    
    /**
     * Save a base64 image and return its path.
     *
     * @param string $base64Image
     * @return string|null
     */
    protected function saveBase64Image($base64Image)
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
            $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
            $decodedImage = base64_decode($base64Image);
    
            if ($decodedImage !== false) {
                $imageType = strtolower($type[1]);
                if (in_array($imageType, ['jpg', 'jpeg', 'gif', 'png', 'webp'])) {
                    $imageResource = imagecreatefromstring($decodedImage);
                    if ($imageResource !== false) {
                        $imageName = time() . '-' . Str::uuid() . '.webp';
                        $destinationPath = public_path('storage/aboutus/');
    
                        if (!File::exists($destinationPath)) {
                            File::makeDirectory($destinationPath, 0755, true, true);
                        }
    
                        $savedPath = $destinationPath . '/' . $imageName;
                        imagewebp($imageResource, $savedPath);
                        imagedestroy($imageResource);
    
                        return 'storage/aboutus/' . $imageName;
                    }
                }
            }
        }
    
        return null;
    }
    
    /* Remove the specified aboutus from storage.
     */
    public function destroy($id)
    {
        $aboutUs = AboutUs::findOrFail($id);
        $aboutUs->delete();
        return redirect()->route('aboutus.index')
                         ->with('success', 'About us deleted successfully.');
    }
}