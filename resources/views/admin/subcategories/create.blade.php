@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h4>Create New SubCategory</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('subcategories.store') }}" method="POST">
                        @csrf

                        {{-- Title Input --}}
                        <div class="form-group mb-3">
                            <label for="title">SubCategory Title</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required oninput="updateMetadataFields()">
                        </div>

                        {{-- Category Selection --}}
                        <div class="form-group mb-3">
                            <label for="category_id">Category</label>
                            <select name="category_id" id="category_id" class="form-control" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Hidden Metadata Inputs --}}
                        <input type="hidden" name="meta_title" id="meta_title" value="{{ old('meta_title') }}">
                        <input type="hidden" name="meta_description" id="meta_description" value="{{ old('meta_description') }}">
                        <input type="hidden" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords') }}">

                        {{-- Submit and Cancel Buttons --}}
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Create SubCategory</button>
                            <a href="{{ route('subcategories.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
