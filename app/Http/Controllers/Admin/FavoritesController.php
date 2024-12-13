<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorites;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{
    public function index()
    {
        // Fetch the favorites with property relations only (no user relation)
        $favorites = Favorites::with('property')->get();
    
        return view('admin.favorites.index', compact('favorites'));
    }
    

    

    public function store(Request $request)
    {
        // Validate the property ID
        $request->validate([
            'properties_id' => 'required|exists:properties,id',
        ]);
    
        // Check if the user has already favorited the property
        $existingFavorite = Favorites::where('properties_id', $request->properties_id)
                                     ->where('email', Auth::user()->email)
                                     ->first();
    
        if ($existingFavorite) {
            return response()->json([
                'status' => 'already_added',
                'message' => 'This property is already in your favorites list.'
            ], 200); // Changed to 200 to be handled as a "success" case in AJAX
        }
    
        // Add the property to the favorites table with the logged-in user's name and email
        $favorite = new Favorites();
        $favorite->properties_id = $request->properties_id;
        $favorite->fav_properties = 'Favorite Property';  // Optional field
        $favorite->name = Auth::user()->name;  // Fetch the user's name from Auth
        $favorite->email = Auth::user()->email; // Fetch the user's email from Auth
        $favorite->save();
    
        // Get the updated favorite count for the logged-in user
        $favoriteCount = Favorites::where('email', Auth::user()->email)->count();
    
        // Return the updated count along with the message
        return response()->json([
            'status' => 'success',
            'message' => 'Property added to favorites successfully!',
            'count' => $favoriteCount
        ], 200);
    }

//     public function getCount()
// {
//     $count = Auth::check() ? Auth::user()->favorites()->count() : 0;
//     return response()->json(['count' => $count]);
// }

   
}
