@extends('admin.layouts.master')

@section('content')
@include('admin.includes.tables')
<hr>
    

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
    <!-- END: Alert -->

    <hr>

    <div class="card">
        <div class="card-header">
            <!-- Add Testimonial Button -->
            <a href="{{ route('testimonials.create') }}" style="text-decoration:none;">
                <button type="button" class="btn btn-block btn-success btn-lg" style="width:auto;">
                    Add Testimonial <i class="fas fa-plus-circle"></i>
                </button>
            </a>
        </div>
        <!-- /.card-header -->

        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Designation</th>
                        <th>Review</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($testimonials as $testimonial)
                        <tr>
                            <td>{{ $testimonial->id }}</td>
                            <td>{{ $testimonial->title }}</td>
                            <td>{{ $testimonial->designation }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($testimonial->review, 50) }}</td>
                            <td>{{ $testimonial->rating }}</td>
                            <td>{{ $testimonial->status ? 'Active' : 'Inactive' }}</td>
                            <td>
                                <!-- Edit Button -->
                                <a href="{{ route('testimonials.edit', $testimonial->id) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('testimonials.destroy', $testimonial->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete this testimonial?')">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
@endsection
