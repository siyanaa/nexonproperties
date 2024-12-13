<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReviewAndRating;

class ReviewsandRatingsController extends Controller
{
    public function index()
    {
        $reviews = ReviewAndRating::with('property')->get();
        return view('admin.reviews.index', compact('reviews'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'reviews' => 'required|string',
        'ratings' => 'required|string',
        'property_id' => 'required|exists:properties,id',  
    ]);

    ReviewAndRating::create([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'reviews' => $request->input('reviews'),
        'ratings' => $request->input('ratings'),
        'properties_id' => $request->input('property_id'),  
    ]);

    return redirect()->back()->with('success', 'Review submitted successfully.');
}
    
public function update(Request $request, ReviewAndRating $review)
{
    $review->update(['status' => $request->status]);
    return redirect()->back()->with('success', 'Review status updated successfully.');
}
     
}
