<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Property;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function create($propertyId)
    {
        $property = Property::findOrFail($propertyId);
        return view('offers.create', compact('property'));
    }

        public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'featured_properties' => 'boolean',
            'offered_properties' => 'boolean',
        ]);

        $property = Property::findOrFail($request->property_id);

        $offer = Offer::updateOrCreate(
            ['properties_id' => $property->id],
            [
                'featured_properties' => $request->has('featured_properties') ? 'Yes' : 'No',
                'offered_properties' => $request->has('offered_properties') ? 'Yes' : 'No',
            ]
        );

        return redirect()->route('property.index')->with('success', 'Offer updated successfully.');
    }
}

