@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    <h1>Edit Category</h1>
    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $category->title }}" required>
        </div>

        <div class="mb-3">
            <label for="meta_keywords" class="form-label">Keywords</label>
            <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" value="{{ $category->metadata->meta_keywords }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Category</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
