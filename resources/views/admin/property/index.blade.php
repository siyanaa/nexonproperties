@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Properties List</h4>
                    <a href="{{ route('property.create') }}" class="btn btn-primary float-end">Add New
                        Property</a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="toast align-items-center text-white bg-success border-0 position-fixed bottom-0 end-0 p-3"
                            role="alert" aria-live="assertive" aria-atomic="true" id="toastMessage">
                            <div class="d-flex">
                                <div class="toast-body">
                                    {{ session('success') }}
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    @if($properties->count() > 0)
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Sub Category</th>
                                    <th>Amenities</th>
                                    <th>Price</th>
                                    <th>Update Time</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($properties as $property)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $property->title }}</td>
                                        <td>{{ $property->category->title }}</td>
                                        <td>{{ $property->subCategory->title }}</td>
                                        <td>
                                            @if(is_array($property->amenities) && count($property->amenities) > 0)
                                                @foreach($property->amenities as $amenityId)
                                                    @php
                                                        $amenity = App\Models\Amenity::find($amenityId);
                                                    @endphp
                                                    @if($amenity)
                                                       {{ $amenity->title }}
                                                    @endif
                                                @endforeach
                                            @else
                                                <span class="text-muted">No amenities</span>
                                            @endif
                                        </td>
                                        
                                        <td>${{ number_format($property->price, 2) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($property->update_time)->format('Y - F - d') }}</td>
                                        <td>
                                            @if($property->status)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>

                                            <a href="{{ route('property.edit', $property->id) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('property.destroy', $property->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete this service?')">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </form>


                                            <!-- Button to trigger Metadata Modal -->
                                            @if($property->metadata)
                                                <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#metadataModal{{ $property->id }}">
                                                    M
                                                </button>
                            

                                                <!-- Metadata Modal with Edit Form -->
                                                <div class="modal fade" id="metadataModal{{ $property->id }}" tabindex="-1" aria-labelledby="metadataModalLabel{{ $property->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="metadataModalLabel{{ $property->id }}">Edit Metadata Details</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('metadata.update', $property->metadata->id) }}" method="POST">
                                                                    @csrf
                                                                   @method('PUT')
                                   
                                                                  <div class="form-group mb-3">
                                                                  <label for="meta_title">Meta Title</label>
                                                                  <input type="text" name="meta_title" id="meta_title" class="form-control" value="{{ old('meta_title', $property->metadata->meta_title) }}" required>
                                                                 </div>
                                   
                                                                <div class="form-group mb-3">
                                                                <label for="meta_description">Meta Description</label>
                                                                <textarea name="meta_description" id="meta_description" class="form-control" rows="3" required>{{ old('meta_description', $property->metadata->meta_description) }}</textarea>
                                                            </div>
                                   
                                                           <div class="form-group mb-3">
                                                           <label for="meta_keywords">Meta Keywords</label>
                                                           @php
                                                               // Decode JSON and prepare keywords for display
                                                               $metaKeywords = json_decode($property->metadata->meta_keywords, true);
                                                               $metaKeywords = is_array($metaKeywords) ? implode("\n", $metaKeywords) : $property->metadata->meta_keywords;
                                                           @endphp
                                                           <textarea name="meta_keywords" id="meta_keywords" class="form-control" rows="3" required>{{ old('meta_keywords', $metaKeywords) }}</textarea>
                                                       </div>
                                   
                                                       <div class="form-group mb-3">
                                                           <label for="slug">Slug</label>
                                                           <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $property->metadata->slug) }}" required>
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

                                            <!-- Image Modal -->

                                                <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#imageModal{{ $property->id }}">
                                                    I
                                                </button>
    
                                            <div class="modal fade" id="imageModal{{ $property->id }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $property->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="imageModalLabel{{ $property->id }}">Edit Property Images</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('property.updateImages', $property->id) }}" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')
    <div class="form-group mb-3">
        <label for="main_image">Main Image</label>
        <input type="file" id="main_image" name="main_image" class="form-control">
    </div>

    <!-- Cropped Main Image Preview -->
    <div class="form-group mb-3" id="cropped-preview-container"
                                                            style="display: none;">
                                                            <label>Cropped Main Image Preview:</label>
                                                            <img id="cropped-image-preview"
                                                                style="max-width: 150px; max-height: 200px; display: block;">
                                                        </div>

    <!-- Hidden input to store the base64 string of the cropped image -->
    <input type="hidden" name="main_image_base64" id="main_image_base64">

    <!-- Cropping Modal -->
    <div class="modal fade" id="cropModal" tabindex="-1" aria-labelledby="cropModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cropModalLabel">Crop Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="image-preview" style="width: 100%; height: auto; display: none;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="saveCrop" class="btn btn-primary">Save Crop</button>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group mb-3">
        <label for="other_images">Other Images</label>
        <input type="file" id="other_images" class="form-control" name="other_images[]" multiple>
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

                                     <!-- Button to trigger Offer Modal -->
                                   <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#offerModal{{ $property->id }}">
                                     O
                                   </button>

                                    <!-- Offer Modal with Create/Edit Form -->
                                   <div class="modal fade" id="offerModal{{ $property->id }}" tabindex="-1" aria-labelledby="offerModalLabel{{ $property->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                     <div class="modal-content" style="min-height: 300px;">
                                       <div class="modal-header">
                                         <h5 class="modal-title" id="offerModalLabel{{ $property->id }}">
                                          {{ $property->offer ? 'Edit' : 'Create' }} Offer for {{ $property->title }}
                                         </h5>
                                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                       </div>
                                      <div class="modal-body">
                                     <form action="{{ route('offers.store') }}" method="POST">
                                    @csrf
                                   <input type="hidden" name="property_id" value="{{ $property->id }}">
                                  <div class="form-group mb-4">
                                  <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="featured_properties" id="featured_properties{{ $property->id }}" value="1" 
                                     {{ $property->offer && $property->offer->featured_properties == 'Yes' ? 'checked' : '' }}>
                                   <label class="form-check-label" for="featured_properties{{ $property->id }}">
                                     Featured 
                                   </label>
                                </div>
                              </div>
                                <div class="form-group mb-4">
                                 <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="offered_properties" id="offered_properties{{ $property->id }}" value="1" 
                                      {{ $property->offer && $property->offer->offered_properties == 'Yes' ? 'checked' : '' }}>
                                       <label class="form-check-label" for="offered_properties{{ $property->id }}">
                                        Special Offer
                                      </label>
                                  </div>
                                 </div>
                                   <div class="form-group mt-4">
                                   <button type="submit" class="btn btn-primary">Save Changes</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                     </div>
                                  </form>
                                 </div>
                                     </div>
                                     </div>
                                   </div>
                               </td>
                             </tr>
                  @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-info">
                    No properties available. <a href="{{ route('property.create') }}">Create a new property</a>.
                </div>
            @endif
        </div>
    </div>
</div>
</div>
</div>

<!-- Include Cropper.js -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

<script>
    let cropper;
    let currentFile;

    // Main image input change event
    document.getElementById('main_image').addEventListener('change', function (e) {
        const files = e.target.files;
        if (files && files.length > 0) {
            currentFile = files[0];
            const url = URL.createObjectURL(currentFile);
            const imagePreview = document.getElementById('image-preview');
            imagePreview.src = url;
            imagePreview.style.display = 'block';

            // Show the crop modal
            const cropModal = new bootstrap.Modal(document.getElementById('cropModal'));
            cropModal.show();

            // Initialize Cropper.js
            if (cropper) {
                cropper.destroy();
            }
            cropper = new Cropper(imagePreview, {
                aspectRatio: 16 / 9, // You can change the aspect ratio as needed
                viewMode: 1,
            });
        }
    });
    document.getElementById('other_images').addEventListener('change', function (e) {
        const files = e.target.files;
        const previewContainer = document.getElementById('other-images-preview');
        previewContainer.innerHTML = ''; // Clear previous previews
        document.getElementById('other-images-preview-container').style.display = 'block'; // Show the preview container

        Array.from(files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function (event) {
                const img = document.createElement('img');
                img.src = event.target.result;
                img.style.maxWidth = '100px';
                img.style.margin = '5px';
                img.style.border = '1px solid #ccc';
                img.style.padding = '2px';
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });


    // Save cropped image data and update hidden input fields
    document.getElementById('saveCrop').addEventListener('click', function () {
        if (!cropper) return;

        cropper.getCroppedCanvas().toBlob((blob) => {
            const reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function () {
                // Set the base64 string of the cropped image into the hidden input
                document.getElementById('main_image_base64').value = reader.result;

                // Set cropped image preview
                const croppedImagePreview = document.getElementById('cropped-image-preview');
                croppedImagePreview.src = reader.result;
                document.getElementById('cropped-preview-container').style.display = 'block';

                // Close modal after saving crop
                const cropModal = bootstrap.Modal.getInstance(document.getElementById('cropModal'));
                cropModal.hide();
            };
        }, 'image/png');
    });


</script>
@endsection




