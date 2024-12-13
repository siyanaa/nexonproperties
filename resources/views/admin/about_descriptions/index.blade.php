@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>About Descriptions</h4>
                    {{-- Check the count of descriptions and hide the button if count >= 5 --}}
                    @if ($aboutDescriptions->count() < 5)
                        <a href="{{ route('admin.about_descriptions.create') }}" class="btn btn-primary float-end">Create New Description</a>
                    @endif
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($aboutDescriptions->count() > 0)
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sn = 1; // Initialize serial number counter
                                @endphp
                                @foreach ($aboutDescriptions as $description)
                                    <tr>
                                        <td>{{ $sn }}</td> <!-- Display the serial number -->
                                        <td>{{ $description->title }}</td>
                                        <td>{{ Str::limit($description->description, 50) }}</td>
                                        <td>
                                            <a href="{{ route('admin.about_descriptions.edit', $description->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('admin.about_descriptions.destroy', $description->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this description?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @php
                                        $sn++; // Increment the serial number counter
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info">
                            No descriptions available. <a href="{{ route('admin.about_descriptions.create') }}">Create a new description</a>.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection