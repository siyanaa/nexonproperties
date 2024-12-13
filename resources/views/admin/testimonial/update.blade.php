@extends('admin.layouts.master')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">Edit Testimonial</h1>
        </div>
        <!-- /.card-header -->

        <!-- form start -->
        <form method="POST" action="{{ route('testimonials.update', $testimonial->id) }}">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" id="title" value="{{ $testimonial->title }}" required>
                </div>

                <div class="form-group">
                    <label for="designation">Designation</label>
                    <input type="text" name="designation" class="form-control" id="designation" value="{{ $testimonial->designation }}">
                </div>

                <div class="form-group">
                    <label for="review">Review</label>
                    <textarea name="review" class="form-control" id="review" rows="4" required>{{ $testimonial->review }}</textarea>
                </div>

                <div class="form-group">
                    <label for="rating">Rating</label>
                    <input type="number" name="rating" class="form-control" id="rating" min="1" max="5" value="{{ $testimonial->rating }}" required>
                </div>

                <!-- Image Upload with Cropper.js -->
                <div class="form-group mb-3">
                    <label for="image">Upload New Image</label>
                    <input type="file" id="image" class="form-control" accept="image/*" multiple>
                </div>

                <!-- Display Current Image -->
                <div class="form-group mb-3" id="current-image-container">
                    <label>Current Image:</label>
                    @if(!empty($testimonial->image))
                        @php
                            $images = is_string($testimonial->image) ? json_decode($testimonial->image, true) : $testimonial->image;
                        @endphp
                        @if(is_array($images) && count($images) > 0)
                            @foreach($images as $image)
                                <img src="{{ asset($image) }}" alt="Testimonial Image" style="max-width: 200px; max-height: 200px;">
                            @endforeach
                        @else
                            <p>No valid image data found.</p>
                        @endif
                    @else
                        <p>No image uploaded.</p>
                    @endif
                </div>

                <!-- Hidden Inputs for Base64 Image -->
                <input type="hidden" name="image[]" id="croppedImage">
                <input type="hidden" name="cropData" id="cropData">

                <!-- Cropped Image Preview -->
                <div class="form-group mb-3" id="cropped-preview-container" style="display: none;">
                    <label>Cropped Image Preview:</label>
                    <img id="cropped-image-preview" style="max-width: 150%; max-height: 200%; display: block;">
                </div>

                <div class="form-group mb-3">
                    <label for="status">Status</label>
                    <div class="form-check">
                        <input type="radio" name="status" id="status_active" value="1" class="form-check-input" 
                               {{ old('status', $testimonial->status) == '1' ? 'checked' : '' }} required>
                        <label for="status_active" class="form-check-label">Active</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="status" id="status_inactive" value="0" class="form-check-input" 
                               {{ old('status', $testimonial->status) == '0' ? 'checked' : '' }} required>
                        <label for="status_inactive" class="form-check-label">Inactive</label>
                    </div>
                </div>
            <!-- /.card-body -->

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update Testimonial</button>
                <a href="{{ route('testimonials.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>


    <!-- Modal for Image Cropping -->
<div class="modal fade" id="cropModal" tabindex="-1" aria-labelledby="cropModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cropModalLabel">Crop Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="image-preview" style="max-width: 150%; max-height: 150%; display: none;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="saveCrop" class="btn btn-primary">Save Crop</button>
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

    function displayExistingImage() {
        const existingImage = document.getElementById('existing_image').value;
        const previewContainer = document.getElementById('image-preview-container');
        
        if (existingImage) {
            try {
                const images = JSON.parse(existingImage);
                if (Array.isArray(images) && images.length > 0) {
                    previewContainer.innerHTML = '';
                    images.forEach(image => {
                        const img = document.createElement('img');
                        img.src = image;
                        img.style.maxWidth = '100%';
                        img.style.maxHeight = '200px';
                        img.style.display = 'block';
                        img.style.marginBottom = '10px';
                        previewContainer.appendChild(img);
                    });
                } else {
                    previewContainer.innerHTML = '<p>No Image Available</p>';
                }
            } catch (e) {
                console.error("Error parsing existing image:", e);
                previewContainer.innerHTML = '<p>Error displaying image</p>';
            }
        } else {
            previewContainer.innerHTML = '<p>No Image Available</p>';
        }
    }

    // Initialize Cropper.js for new image upload
    document.getElementById('image').addEventListener('change', function (e) {
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

            if (cropper) {
                cropper.destroy();
            }
            cropper = new Cropper(imagePreview, {
                aspectRatio: 16 / 9,
                viewMode: 1,
            });
        }
    });

    // Save cropped image data and update hidden input fields
    document.getElementById('saveCrop').addEventListener('click', function () {
        if (!cropper) return;

        const cropData = cropper.getData();
        document.getElementById('cropData').value = JSON.stringify([{
            width: Math.round(cropData.width),
            height: Math.round(cropData.height),
            x: Math.round(cropData.x),
            y: Math.round(cropData.y),
        }]);

        cropper.getCroppedCanvas().toBlob((blob) => {
            const reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function () {
                document.getElementById('croppedImage').value = reader.result;
                document.getElementById('cropped-image-preview').src = reader.result;
                document.getElementById('cropped-preview-container').style.display = 'block';
            };

            // Close modal after saving crop
            const cropModal = bootstrap.Modal.getInstance(document.getElementById('cropModal'));
            cropModal.hide();
        }, 'image/png');
    });

    // Initialize preview on page load
    window.addEventListener('load', displayExistingImage);
</script>
@endsection
