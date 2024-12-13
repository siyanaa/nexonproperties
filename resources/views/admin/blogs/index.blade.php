@extends('admin.layouts.master')

<!-- Main content -->
@section('content')
    @include('admin.includes.tables')

    <hr>
    
    <a href="{{ route('admin.blogs.create') }}" style="text-decoration:none;">
        <button type="button" class="btn btn-block btn-success btn-lg" style="width:auto;">
            Add Blog <i class="fas fa-plus-circle"></i>
        </button>
    </a>

    <!-- BEGIN: Alert -->
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
            <h3 class="card-title">Blogs</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" role="grid"
                            aria-describedby="example1_info">
                            <thead>
                                <tr role="row">
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($blogs as $blog)
                                    <tr>
                                        <td>{{ $blog->title }}</td>
                                        <td>{{ $blog->author ?? 'N/A' }}</td>
                                        <td>{{ $blog->status ? 'Active' : 'Inactive' }}</td>
                                        <td>
                                            <div style="display: flex; flex-direction: row; gap: 5px;">
                                                <!-- Edit Button -->
                                                <a href="{{ route('admin.blogs.edit', ['blog' => $blog->id]) }}" class="btn btn-outline-primary btn-sm" onclick="return confirm('Are you sure you want to edit this blog?');">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            
                                                <!-- Delete Button -->
                                                <form action="{{ route('admin.blogs.destroy', ['blog' => $blog->id]) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this blog?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </form>

                                                <!-- Metadata Edit Button -->
                                                @if($blog->metadata)
                                                    <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#metadataModal{{ $blog->id }}">
                                                        M
                                                    </button>

                                                  <!-- Metadata Modal with Edit Form -->
                                                  <div class="modal fade" id="metadataModal{{ $blog->id }}" tabindex="-1" aria-labelledby="metadataModalLabel{{ $blog->id }}" aria-hidden="true">
                                                  <div class="modal-dialog modal-lg">
                                                  <div class="modal-content">
                                                   <div class="modal-header">
                                                <h5 class="modal-title" id="metadataModalLabel{{ $blog->id }}">Edit Metadata Details for {{ $blog->title }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                     <div class="modal-body">
                                  <form action="{{ route('metadata.update', $blog->metadata->id) }}" method="POST">
                                 @csrf
                                @method('PUT')

                               <div class="form-group mb-3">
                               <label for="meta_title">Meta Title</label>
                               <input type="text" name="meta_title" id="meta_title" class="form-control" value="{{ old('meta_title', $blog->metadata->meta_title) }}" required>
                              </div>

                             <div class="form-group mb-3">
                             <label for="meta_description">Meta Description</label>
                             <textarea name="meta_description" id="meta_description" class="form-control" rows="3" required>{{ old('meta_description', $blog->metadata->meta_description) }}</textarea>
                         </div>

                        <div class="form-group mb-3">
                        <label for="meta_keywords">Meta Keywords</label>
                        @php
                            // Decode JSON and prepare keywords for display
                            $metaKeywords = json_decode($blog->metadata->meta_keywords, true);
                            $metaKeywords = is_array($metaKeywords) ? implode("\n", $metaKeywords) : $blog->metadata->meta_keywords;
                        @endphp
                        <textarea name="meta_keywords" id="meta_keywords" class="form-control" rows="3" required>{{ old('meta_keywords', $metaKeywords) }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="slug">Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $blog->metadata->slug) }}" required>
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
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->

    <!-- Page specific script -->
    <script>
        $(function() {
            $.noConflict();
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
