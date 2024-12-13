@extends('admin.layouts.master')

@section('content')
    <h1>Edit Metadata</h1>
    <form action="{{ route('metadata.update', $metadata->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="meta_title" class="form-label">Meta Title</label>
            <input type="text" class="form-control" id="meta_title" name="meta_title" value="{{ $metadata->meta_title }}" required>
        </div>
        <div class="mb-3">
            <label for="meta_description" class="form-label">Meta Description</label>
            <textarea class="form-control" id="meta_description" name="meta_description" rows="3" required>{{ $metadata->meta_description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="meta_keywords" class="form-label">Meta Keywords</label>
            <textarea name="meta_keywords" rows="3">{{ old('meta_keywords', $metadata->meta_keywords) }}</textarea>
        </div>
        
        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control" id="slug" name="slug" value="{{ $metadata->slug }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
