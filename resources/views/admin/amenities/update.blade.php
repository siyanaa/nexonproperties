@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Amenity</h4>
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

                    <form action="{{ route('amenities.update', $amenity->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Title Input --}}
                        <div class="form-group mb-3">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ $amenity->title }}" required>
                        </div>

                        {{-- Description Input --}}
                        <div class="form-group mb-3">
                            <label for="description">Description (optional)</label>
                            <textarea name="description" id="description" class="form-control">{{ $amenity->description }}</textarea>
                        </div>

                        {{-- Submit and Cancel Buttons --}}
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Update Amenity</button>
                            <a href="{{ route('amenities.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
