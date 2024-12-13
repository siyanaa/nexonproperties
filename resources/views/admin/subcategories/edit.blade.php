@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    <h1>Edit SubCategory</h1>
    <form action="{{ route('subcategories.update', $subCategory->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Title Input --}}
        <div class="mb-3">
            <label for="title" class="form-label">SubCategory Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $subCategory->title }}" required oninput="updateMetadataFields()">
        </div>

        {{-- Category Selection --}}
        <div class="form-group mb-3">
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $subCategory->category_id == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                @endforeach
            </select>
        </div>

        {{-- Hidden Metadata Inputs --}}
        <input type="hidden" name="meta_title" id="meta_title" value="{{ old('meta_title', $subCategory->metadata->meta_title) }}">
        <input type="hidden" name="meta_description" id="meta_description" value="{{ old('meta_description', $subCategory->metadata->meta_description) }}">
        <input type="hidden" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords', $subCategory->metadata->meta_keywords) }}">

        {{-- Submit and Cancel Buttons --}}
        <button type="submit" class="btn btn-primary">Update SubCategory</button>
        <a href="{{ route('subcategories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
    // Function to update metadata fields based on the SubCategory Title input
    function updateMetadataFields() {
        const title = document.getElementById('title').value;
        const metaTitle = document.getElementById('meta_title');
        const metaDescription = document.getElementById('meta_description');
        const metaKeywords = document.getElementById('meta_keywords');

        // Set metadata fields dynamically
        metaTitle.value = title;
        metaDescription.value = `Description for ${title}`;
        metaKeywords.value = title.split(' ').join(', '); // Simple keywords generation
    }
</script>
@endsection
