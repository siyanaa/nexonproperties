<?php

namespace App\Http\Controllers;
use App\Models\Property;
use App\Models\Category;
use App\Models\Service;
use App\Models\Blog;
use App\Models\Testimonial;
use App\Models\Whyus;
use App\Models\AboutUs;
use App\Models\Subcategory;
use App\Models\Amenity;
use App\Models\Address;
use App\Models\Favorites;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class FrontViewController extends Controller
{
    private function extractAmenities($amenities)
    {
        if (is_string($amenities)) {
            return json_decode($amenities, true) ?? [];
        } elseif (is_array($amenities)) {
            return $amenities;
        }
        return [];
    }

    public function index()
    {
        // Fetch necessary data for the view
        $services = Service::where('status', 1)->latest()->take(4)->get();
        $blogs = Blog::with('metadata')->where('status', 1)->latest()->get();
        $testimonials = Testimonial::where('status', 1)->latest()->get();
        $whyuss = Whyus::where('status', 1)->latest()->get();
        $aboutuss = AboutUs::where('status', 1)->first();
        $properties = Property::where('status', 1)->latest()->take(6)->get();

        $suburbCounts = Property::join('addresses', 'properties.address_id', '=', 'addresses.id')
            ->select('addresses.suburb', DB::raw('count(*) as count'))
            ->groupBy('addresses.suburb')
            ->orderByDesc('count')
            ->take(4)
            ->get();

        $suburbProperties = Property::join('addresses', 'properties.address_id', '=', 'addresses.id')
            ->whereIn('addresses.suburb', $suburbCounts->pluck('suburb'))
            ->select('properties.*', 'addresses.suburb')
            ->whereIn(DB::raw('(addresses.suburb, properties.id)'), function ($query) {
                $query->select('addresses.suburb', DB::raw('MIN(properties.id) as id'))
                    ->from('properties')
                    ->join('addresses', 'properties.address_id', '=', 'addresses.id')
                    ->groupBy('addresses.suburb');
                })
            ->get()
            ->keyBy('suburb');

        $categories = Category::all();
        $states = Address::distinct('state')->pluck('state');
        $subcategories = Subcategory::all();
        $amenities = Amenity::all();

        return view('frontend.welcome', compact([
            'services', 'blogs', 'aboutuss', 'testimonials', 'whyuss', 
            'properties', 'categories', 'subcategories', 'states', 
            'amenities', 'suburbCounts' ,'suburbProperties'
        ]));
    }


    public function properties(Request $request)
{
    $categoryId = $request->query('categoryId');
    $suburb = $request->query('suburb');

    // Fetch all categories for the navbar
    $categories = Category::all();

    // Fetch properties, optionally filtered by category and/or suburb, and where status is active
    $propertiesQuery = Property::where('status', '1');

    if ($categoryId) {
        $propertiesQuery->where('category_id', $categoryId);
    }

    if ($suburb) {
        $propertiesQuery->whereHas('address', function($query) use ($suburb) {
            $query->where('suburb', $suburb);
        });
    }

    $properties = $propertiesQuery->paginate(24);
    $states = Address::distinct('state')->pluck('state');
    $amenities = Amenity::all();

    $otherImages = !empty($properties->other_images) ? json_decode($properties->other_images, true) : [];

    return view('frontend.properties', compact('properties', 'categories', 'states', 'amenities', 'otherImages', 'suburb'));
}
    
    // public function singlePost($slug)
    // {
    //     $blogs = Blog::where('slug', $slug)->firstOrFail();
    //     $relatedPosts = blog::where('id', '!=', $blogs->id)->get();
    //     return view('singleblogpost', compact('blogs', 'relatedPosts'));
    // }

    public function userFavorites()
    {
        // Fetch only the authenticated user's favorites with related property details
        $favorites = Favorites::with('property')
                              ->where('email', Auth::user()->email)
                              ->get();

        return view('frontend.favorites.index', compact('favorites'));
    }
}