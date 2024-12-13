@extends('admin.layouts.master')

@section('content')
    @include('admin.includes.tables')

    <hr>

    {{-- <a href="{{ route('metadata.create') }}" style="text-decoration:none;">
        <button type="button" class="btn btn-block btn-success btn-lg" style="width:auto;">
            Add Metadata <i class="fas fa-plus-circle"></i>
        </button>
    </a>  --}}

    <div class="container">
        @if (session()->has('success'))
            <div class="alert alert-success alert-icon d-flex gap-4" role="alert" style="width: 700px;">
                <div class="d-flex gap-4">
                    <div class="alert-icon-aside">
                        <i class="far fa-flag"></i>
                    </div>
                    <div class="alert-icon-content">
                        {{ session('success') }}
                    </div>
                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>

    <hr>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Metadata</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Meta Title</th>
                        <th>Meta Description</th>
                        <th>Meta Keywords</th>
                        <th>Slug</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($metadata as $meta)
                        <tr>
                            <td>{{ $meta->meta_title }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($meta->meta_description, 50) }}</td>
                            <td>
                                @php
                                    // Decode JSON and ensure it's an array
                                    $keywords = json_decode($meta->meta_keywords, true);
                                    if (!is_array($keywords)) {
                                        $keywords = [];
                                    }
                                @endphp
                                @foreach($keywords as $keyword)
                                    <div>{{ $keyword }}</div>
                                @endforeach
                            </td>
                            <td>{{ $meta->slug }}</td>
                            <td>
                                <a href="{{ route('metadata.edit', $meta->id) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('metadata.destroy', $meta->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete this metadata?')">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
