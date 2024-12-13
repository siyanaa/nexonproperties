<?php
// app/Http/Controllers/Admin/AboutDescriptionController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutDescription;
use Illuminate\Http\Request;

class AboutDescriptionController extends Controller
{
    public function index()
    {
        $aboutDescriptions = AboutDescription::all();
        return view('admin.about_descriptions.index', compact('aboutDescriptions'));
    }

    public function create()
    {
        return view('admin.about_descriptions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        AboutDescription::create($request->all());

        return redirect()->route('admin.about_descriptions.index')->with('success', 'Description created successfully.');
    }

    public function edit(AboutDescription $aboutDescription)
    {
        return view('admin.about_descriptions.edit', compact('aboutDescription'));
    }

    public function update(Request $request, AboutDescription $aboutDescription)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $aboutDescription->update($request->all());

        return redirect()->route('admin.about_descriptions.index')->with('success', 'Description updated successfully.');
    }

    public function destroy(AboutDescription $aboutDescription)
    {
        $aboutDescription->delete();

        return redirect()->route('admin.about_descriptions.index')->with('success', 'Description deleted successfully.');
    }
}