@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Categories List</h4>
                    <a href="{{ route('categories.create') }}" class="btn btn-primary float-end">Add New Category</a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($categories->count() > 0)
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>Title</th>
                                    <th>Meta Title</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $category->title }}</td>
                                        <td>{{ $category->metadata ? $category->metadata->meta_title : 'No Metadata' }}</td>
                                        <td>
                                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>

                                            <!-- Button to trigger Metadata Modal -->
                                            @if($category->metadata)
                                                <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#metadataModal{{ $category->id }}">
                                                    M
                                                </button>

                                                <!-- Metadata Modal -->
                                                <div class="modal fade" id="metadataModal{{ $category->id }}" tabindex="-1" aria-labelledby="metadataModalLabel{{ $category->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="metadataModalLabel{{ $category->id }}">Edit Metadata Details</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('metadata.update', $category->metadata->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('PUT')

                                                                    <div class="form-group mb-3">
                                                                        <label for="meta_title">Meta Title</label>
                                                                        <input type="text" name="meta_title" id="meta_title" class="form-control" value="{{ old('meta_title', $category->metadata->meta_title) }}" required>
                                                                    </div>

                                                                    <div class="form-group mb-3">
                                                                        <label for="meta_description">Meta Description</label>
                                                                        <textarea name="meta_description" id="meta_description" class="form-control" rows="3" required>{{ old('meta_description', $category->metadata->meta_description) }}</textarea>
                                                                    </div>

                                                                    <div class="form-group mb-3">
                                                                        <label for="meta_keywords">Meta Keywords</label>
                                                                        @php
                                                                            // Decode JSON and prepare keywords for display
                                                                            $metaKeywords = json_decode($category->metadata->meta_keywords, true);
                                                                            $metaKeywords = is_array($metaKeywords) ? implode("\n", $metaKeywords) : $category->metadata->meta_keywords;
                                                                        @endphp
                                                                        <textarea name="meta_keywords" id="meta_keywords" class="form-control" rows="3" required>{{ old('meta_keywords', $metaKeywords) }}</textarea>
                                                                    </div>

                                                                    <div class="form-group mb-3">
                                                                        <label for="slug">Slug</label>
                                                                        <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $category->metadata->slug) }}" required>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info">
                            No categories available. <a href="{{ route('categories.create') }}">Create a new category</a>.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
