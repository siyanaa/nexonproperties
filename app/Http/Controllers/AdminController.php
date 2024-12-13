<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Property;
use App\Models\Category;

class AdminController extends Controller
{
    public function index() {
        $user = Auth::user();
    
        // Fetch the count of properties by status
        $availableCount = Property::where('availability_status', 'available')->count();
        $soldCount = Property::where('availability_status', 'sold')->count();
        $rentalCount = Property::where('availability_status', 'rental')->count();
        
        // Fetch categories with their property counts
        $categories = Category::withCount('properties')->get();
    
        return view('admin.index', [
            'user' => $user,
            'availableCount' => $availableCount,
            'soldCount' => $soldCount,
            'rentalCount' => $rentalCount,
            'categories' => $categories,
        ]);
    }
}