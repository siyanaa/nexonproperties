@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Services List</h4>
                    <a href="{{ route('services.create') }}" class="btn btn-primary float-end">Add New Service</a>
                </div>
                <div class="card-body">
                    <!-- Display success message -->
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Check if there are any services -->
                    @if($services->count() > 0)
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.N</th> 
                                    <th>Title</th>
                                    <th>Subtitle</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($services as $service)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $service->title }}</td>
                                        <td>{{ $service->subtitle }}</td>
                                        <td>
                                            @if($service->status)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td> 
                                            <a href="{{ route('services.edit', $service->id) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('services.destroy', $service->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete this service?')">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </form>

                                            <!-- Button to trigger Metadata Modal -->
                                            @if($service->metadata)
                                                <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#metadataModal{{ $service->id }}">
                                                    M
                                                </button>

                                                <!-- Metadata Modal with Edit Form -->
                                                <div class="modal fade" id="metadataModal{{ $service->id }}" tabindex="-1" aria-labelledby="metadataModalLabel{{ $service->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="metadataModalLabel{{ $service->id }}">Edit Metadata Details</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('metadata.update', $service->metadata->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('PUT')

                                                                    <div class="form-group mb-3">
                                                                        <label for="meta_title">Meta Title</label>
                                                                        <input type="text" name="meta_title" id="meta_title" class="form-control" value="{{ old('meta_title', $service->metadata->meta_title) }}" required>
                                                                    </div>

                                                                    <div class="form-group mb-3">
                                                                        <label for="meta_description">Meta Description</label>
                                                                        <textarea name="meta_description" id="meta_description" class="form-control" rows="3" required>{{ old('meta_description', $service->metadata->meta_description) }}</textarea>
                                                                    </div>

                                                                    <div class="form-group mb-3">
                                                                        <label for="meta_keywords">Meta Keywords</label>
                                                                        @php
                                                                            // Decode JSON and prepare keywords for display
                                                                            $metaKeywords = json_decode($service->metadata->meta_keywords, true);
                                                                            $metaKeywords = is_array($metaKeywords) ? implode("\n", $metaKeywords) : $service->metadata->meta_keywords;
                                                                        @endphp
                                                                        <textarea name="meta_keywords" id="meta_keywords" class="form-control" rows="3" required>{{ old('meta_keywords', $metaKeywords) }}</textarea>
                                                                    </div>

                                                                    <div class="form-group mb-3">
                                                                        <label for="slug">Slug</label>
                                                                        <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $service->metadata->slug) }}" required>
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
                            No services available. <a href="{{ route('services.create') }}">Create a new service</a>.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection