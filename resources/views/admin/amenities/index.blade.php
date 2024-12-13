@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header">
                    <h4>Amenities List</h4>
                    <a href="{{ route('amenities.create') }}" class="btn btn-primary">Add New Amenity</a>
                </div>
                <div class="card-body">
                    @if($amenities->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($amenities as $amenity)
                                    <tr>
                                        <td>{{ $amenity->title }}</td>
                                        <td>{{ $amenity->description }}</td>
                                        <td>
                                            <a href="{{ route('amenities.edit', $amenity->id) }}" class="btn btn-warning">Edit</a>

                                            <!-- Delete Button -->
                                            <form action="{{ route('amenities.destroy', $amenity->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this amenity?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div class="alert alert-info">
                            No amenities available. <a href="{{ route('amenities.create') }}">Create a new category</a>.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
