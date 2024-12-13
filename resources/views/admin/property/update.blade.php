@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Property</h4>
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

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Property edit form -->
                    <form action="{{ route('property.update', $property->id) }}" method="POST"
                        enctype="multipart/form-data" id="propertyForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="cropData" id="cropData">
                        <input type="hidden" name="main_image_cropped" id="croppedImage">

                        <!-- Title -->
                        <div class="form-group mb-3">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control"
                                value="{{ old('title', $property->title) }}" required>
                        </div>

                        <!-- Description -->
                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="5"
                                required>{{ old('description', $property->description) }}</textarea>
                        </div>


                       <!-- Category -->
<div class="form-group mb-3">
    <label for="category_id">Category</label>
    <select name="category_id" id="category_id" class="form-control" required>
        <option value="">Choose Category</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id', $property->category_id) == $category->id ? 'selected' : '' }}>
                {{ $category->title }}
            </option>
        @endforeach
    </select>
</div>

<!-- Sub Category -->
<div class="form-group mb-3">
    <label for="sub_category_id">Sub Category</label>
    <select name="sub_category_id" id="sub_category_id" class="form-control" required>
        <option value="">Choose Sub Category</option>
    </select>
</div>

<!-- Amenities -->
<div class="form-group">
    <label for="amenities">Amenities</label>
    @foreach($amenities as $amenity)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="amenities[]" value="{{ $amenity->id }}" id="amenity_{{ $amenity->id }}"
                   {{ (isset($property) && in_array($amenity->id, $property->amenities ?? [])) ? 'checked' : '' }}>
            <label class="form-check-label" for="amenity_{{ $amenity->id }}">
                {{ $amenity->title }}
            </label>
        </div>
    @endforeach
</div>



                        <!-- Street -->
                        <div class="form-group mb-3">
                            <label for="street">Street</label>
                            <input type="text" name="street" id="street" class="form-control"
                                value="{{ old('street', $property->street) }}" required>
                        </div>

                        <!-- Suburb -->
                        <div class="form-group mb-3">
                            <label for="suburb">Suburb</label>
                            <select name="suburb" id="suburb" class="form-control" required>
                                <option value="">Select Suburb</option>
                                <option value="Sydney" {{ old('suburb') == 'Sydney' ? 'selected' : '' }}>Sydney
                                </option>
                                <option value="Parramatta" {{ old('suburb') == 'Parramatta' ? 'selected' : '' }}>
                                    Parramatta</option>
                                <option value="Penrith" {{ old('suburb') == 'Penrith' ? 'selected' : '' }}>Penrith
                                </option>
                                <option value="Manly" {{ old('suburb') == 'Manly' ? 'selected' : '' }}>Manly
                                </option>
                                <option value="Bondi" {{ old('suburb') == 'Bondi' ? 'selected' : '' }}>Bondi
                                </option>
                                <option value="Coogee" {{ old('suburb') == 'Coogee' ? 'selected' : '' }}>Coogee
                                </option>
                                <option value="Randwick" {{ old('suburb') == 'Randwick' ? 'selected' : '' }}>
                                    Randwick</option>
                                <option value="Maroubra" {{ old('suburb') == 'Maroubra' ? 'selected' : '' }}>
                                    Maroubra</option>
                                <option value="Blacktown" {{ old('suburb') == 'Blacktown' ? 'selected' : '' }}>
                                    Blacktown</option>
                                <option value="Liverpool" {{ old('suburb') == 'Liverpool' ? 'selected' : '' }}>
                                    Liverpool</option>
                                <option value="Fairfield" {{ old('suburb') == 'Fairfield' ? 'selected' : '' }}>
                                    Fairfield</option>
                                <option value="Dee Why" {{ old('suburb') == 'Dee Why' ? 'selected' : '' }}>Dee Why
                                </option>
                                <option value="Narrabeen" {{ old('suburb') == 'Narrabeen' ? 'selected' : '' }}>
                                    Narrabeen</option>
                                <option value="Palm Beach" {{ old('suburb') == 'Palm Beach' ? 'selected' : '' }}>
                                    Palm Beach</option>
                                <option value="Newtown" {{ old('suburb') == 'Newtown' ? 'selected' : '' }}>Newtown
                                </option>
                                <option value="Balmain" {{ old('suburb') == 'Balmain' ? 'selected' : '' }}>Balmain
                                </option>
                                <option value="Glebe" {{ old('suburb') == 'Glebe' ? 'selected' : '' }}>Glebe
                                </option>
                                <option value="Ashfield" {{ old('suburb') == 'Ashfield' ? 'selected' : '' }}>
                                    Ashfield</option>
                                <option value="Strathfield" {{ old('suburb') == 'Strathfield' ? 'selected' : '' }}>
                                    Strathfield</option>
                                <option value="North Sydney"
                                    {{ old('suburb') == 'North Sydney' ? 'selected' : '' }}>North Sydney</option>
                                <option value="Mosman" {{ old('suburb') == 'Mosman' ? 'selected' : '' }}>Mosman
                                </option>
                                <option value="Chatswood" {{ old('suburb') == 'Chatswood' ? 'selected' : '' }}>
                                    Chatswood</option>
                                <option value="Hornsby" {{ old('suburb') == 'Hornsby' ? 'selected' : '' }}>Hornsby
                                </option>
                                <option value="Turramurra" {{ old('suburb') == 'Turramurra' ? 'selected' : '' }}>
                                    Turramurra</option>
                                <option value="Hurstville" {{ old('suburb') == 'Hurstville' ? 'selected' : '' }}>
                                    Hurstville</option>
                                <option value="Kogarah" {{ old('suburb') == 'Kogarah' ? 'selected' : '' }}>Kogarah
                                </option>
                                <option value="Rockdale" {{ old('suburb') == 'Rockdale' ? 'selected' : '' }}>
                                    Rockdale</option>
                            </select>
                        </div>
                        <!-- State -->
                        <div class="form-group mb-3">
                            <label for="state">State</label>
                            <select name="state" id="state" class="form-control" required>
                                <option value="">Select State</option>
                                <option value="NSW"
                                    {{ old('state', $property->state) == 'NSW' ? 'selected' : '' }}>New South Wales
                                    (NSW)</option>
                            </select>

                        <!-- Post Code -->
                        <div class="form-group mb-3">
                            <label for="post_code">Post Code</label>
                            <input type="number" name="post_code" id="post_code" min="0" minlength="4"
                                class="form-control" value="{{ old('post_code', $property->post_code) }}" required>
                        </div>

                        <!-- Country -->
                        <div class="form-group mb-3">
                            <label for="country">Country</label>
                            <input type="text" name="country" id="country" class="form-control"
                                value="{{ old('country', $property->country) }}">
                        </div>

                        <!-- Price -->
                        <div class="form-group mb-3">
                            <label for="price">Price</label>
                            <input type="number" name="price" id="price" class="form-control" min="0"
                                value="{{ old('price', $property->price) }}" required>
                        </div>

                        <!-- Price Type -->
                        <div class="form-group mb-3">
                            <label for="price_type">Price Type</label>
                            <select name="price_type" id="price_type" class="form-control" required>
                                <option value="fixed" {{ old('price_type', $property->price_type) == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                <option value="negotiable" {{ old('price_type', $property->price_type) == 'negotiable' ? 'selected' : '' }}>Negotiable</option>
                                <option value="on_request" {{ old('price_type', $property->price_type) == 'on_request' ? 'selected' : '' }}>On Request</option>
                            </select>
                        </div>

                        <!-- Bedrooms -->
                        <div class="form-group mb-3">
                            <label for="bedrooms">Bedrooms</label>
                            <input type="number" name="bedrooms" id="bedrooms" class="form-control" min="0"
                                value="{{ old('bedrooms', $property->bedrooms) }}" required>
                        </div>

                        <!-- Bathrooms -->
                        <div class="form-group mb-3">
                            <label for="bathrooms">Bathrooms</label>
                            <input type="number" name="bathrooms" id="bathrooms" class="form-control" min="0"
                                value="{{ old('bathrooms', $property->bathrooms) }}" required>
                        </div>

                        <!-- Area -->
                        <div class="form-group mb-3">
                            <label for="area">Area (sq ft)</label>
                            <input type="number" name="area" id="area" class="form-control" min="0"
                                value="{{ old('area', $property->area) }}" required>
                        </div>

                        <!-- Status -->
                        <div class="form-group mb-3">
                            <label for="status">Status</label>
                            <div class="form-check">
                                <input type="radio" name="status" id="status_active" value="1" class="form-check-input"
                                    {{ old('status', $property->status) == '1' ? 'checked' : '' }} required>
                                <label for="status_active" class="form-check-label">Active</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="status" id="status_inactive" value="0"
                                    class="form-check-input" {{ old('status', $property->status) == '0' ? 'checked' : '' }} required>
                                <label for="status_inactive" class="form-check-label">Inactive</label>
                            </div>
                        </div>

                        <!-- Availability Status -->
                        <div class="form-group mb-3">
                            <label for="availability_status">Availability Status</label>
                            <select name="availability_status" id="availability_status" class="form-control" required>
                                <option value="available" {{ old('availability_status', $property->availability_status) == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="sold" {{ old('availability_status', $property->availability_status) == 'sold' ? 'selected' : '' }}>Sold</option>
                                <option value="rental" {{ old('availability_status', $property->availability_status) == 'rental' ? 'selected' : '' }}>Rental</option>
                            </select>
                        </div>

                        <!-- Rental Period -->
                        <div class="form-group mb-3">
                            <label for="rental_period">Rental Period</label>
                            <input type="text" name="rental_period" id="rental_period" class="form-control"
                                value="{{ old('rental_period', $property->rental_period) }}">
                        </div>

                   
                    
                       
                       

                        <!-- Keywords -->
                        <div class="form-group mb-3">
                            <label for="keywords">Keywords</label>
                            <input type="text" name="keywords" id="keywords" class="form-control"
                                value="{{ old('keywords', $property->metadata->meta_keywords) }}">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Property</button>
                            <a href="{{ route('property.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
                <img id="image-preview" style="width: 100%; height: auto; display: none;">
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
        document.getElementById('cropData').value = JSON.stringify({
            width: Math.round(cropData.width),
            height: Math.round(cropData.height),
            x: Math.round(cropData.x),
            y: Math.round(cropData.y)
        });

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
            };

            // Close modal after saving crop
            const cropModal = bootstrap.Modal.getInstance(document.getElementById('cropModal'));
            cropModal.hide();
        }, 'image/png');
    });

    // Preview for other images
    document.getElementById('other_images').addEventListener('change', function (e) {
        const files = e.target.files;
        const previewContainer = document.getElementById('other-images-preview');
        previewContainer.innerHTML = ''; // Clear previous previews
        document.getElementById('other-images-preview-container').style.display = 'block';

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

    // Show toast message after form submission
    document.addEventListener('DOMContentLoaded', function () {
        if (document.querySelector('.toast')) {
            const toast = new bootstrap.Toast(document.querySelector('.toast'));
            toast.show();
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
    const categorySelect = document.getElementById('category_id');
    const subCategorySelect = document.getElementById('sub_category_id');
    
    // Object to store all subcategories grouped by category ID
    const subCategories = @json($subCategories->groupBy('category_id'));

    function updateSubCategories() {
        const selectedCategoryId = categorySelect.value;
        
        // Store the current selection
        const currentSelection = subCategorySelect.value;
        
        // Clear current options
        subCategorySelect.innerHTML = '<option value="">Choose Sub Category</option>';
        
        if (selectedCategoryId && subCategories[selectedCategoryId]) {
            subCategories[selectedCategoryId].forEach(function(subCategory) {
                const option = new Option(subCategory.title, subCategory.id);
                option.selected = (subCategory.id == currentSelection);
                subCategorySelect.add(option);
            });
        }
    }

    categorySelect.addEventListener('change', updateSubCategories);

    // Initial update on page load
    updateSubCategories();
});
    });

    document.addEventListener('DOMContentLoaded', function () {
    const categorySelect = document.getElementById('category_id');
    const subCategorySelect = document.getElementById('sub_category_id');
    
    // Object to store all subcategories grouped by category ID
    const subCategories = @json($subCategories->groupBy('category_id'));

    function updateSubCategories() {
        const selectedCategoryId = categorySelect.value;
        
        // Store the current selection
        const currentSelection = subCategorySelect.value;
        
        // Clear current options
        subCategorySelect.innerHTML = '<option value="">Choose Sub Category</option>';
        
        if (selectedCategoryId && subCategories[selectedCategoryId]) {
            subCategories[selectedCategoryId].forEach(function(subCategory) {
                const option = new Option(subCategory.title, subCategory.id);
                option.selected = (subCategory.id == currentSelection);
                subCategorySelect.add(option);
            });
        }
    }

    categorySelect.addEventListener('change', updateSubCategories);

    // Initial update on page load
    updateSubCategories();
});
</script>
@endsection


