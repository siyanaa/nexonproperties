@extends("frontend.layouts.master")
@section("content")
<section class="container-fluid singleprojectpage">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row py-2">
                    <!-- Main Property Image -->
                    <div class="col-md-8">
                        @php
                            $mainImages = !empty($properties->main_image) ? json_decode($properties->main_image, true) : [];
                            $mainImage = !empty($mainImages) ? asset($mainImages[0]) : asset('images/default-placeholder.png');
                        @endphp
                        <img src="{{ $mainImage }}" alt="Property Image"
                            class="imagecontroller imagecontrollerheight rounded">

                        <div class="review-addtofavourite d-flex gap-1 mx-1">
                            <span class="btn-buttonyellow favourite" data-property-id="{{ $properties->id }}">Add
                                Favourite</span>
                            <span class="btn-buttongreen" onclick="openReviewfun()">Review</span>
                        </div>
                    </div>

                    <script>
                        document.querySelector('.favourite').addEventListener('click', function () {
                            var propertyId = this.getAttribute('data-property-id');

                            // Perform the AJAX request to store favorites
                            $.ajax({
                                url: '{{ route("favorites.store") }}',
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    properties_id: propertyId
                                },
                                success: function (response) {
                                    if (response.status === 'success') {
                                        // Update the favorite count in the navbar
                                        let counterElement = document.querySelector('.counter');
                                        if (counterElement) {
                                            counterElement.textContent = response.count;
                                            localStorage.setItem('favoriteCount', response.count);
                                        }
                                        alert(response.message);
                                    } else if (response.status === 'already_added') {
                                        alert('Already added to favorites');
                                    }
                                },
                                error: function (xhr) {
                                    alert('An error occurred while processing your request');
                                }
                            });
                        });

                    </script>


                    <!-- Property Images -->






                    <!-- Include Bootstrap and jQuery -->
                    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
                    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                    <style>
                        .modal-body {
                            position: relative;
                            overflow: hidden;
                            padding: 0;

                        }

                        #modalImage {
                            height: 50vh;
                            width: 90%;
                            object-fit: cover;

                        }

                        .modal-content {
                            background-color: #1F4B43;
                            border: none;
                            max-width: 90%;
                            width: 90%;
                            top: 2rem
                        }

                        .close {
                            height: 7vh;
                            width: 4vw;
                            font-size: 30px;
                            border-radius: 8px;
                            display: block;
                        }
                    </style>


                    @php
                        $limitedImages = array_slice($otherImages, 0, 6);
                    @endphp
                    <div class="col-md-4">
                        <div class="row">
                            @foreach ($limitedImages as $index => $image)
                                <div class="col-md-6 p-1 px-2">
                                    <img src="{{ asset($image) }}" alt="Property Image"
                                        class="property-image property-imageheight rounded" data-toggle="modal"
                                        data-target="#imageModal" data-img="{{ asset($image) }}">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Modal -->
                    <!-- Modal -->
                    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog"
                        aria-labelledby="imageModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <!-- Use modal-lg for large size -->
                            <div class="modal-content">
                                <div class="modal-header d-flex justify-content-between">
                                    <h5 class="modal-title md-text1" id="imageModalLabel">Property Image</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center">
                                    <img id="modalImage" src="" alt="Property Image" class="img-fluid">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="prevBtn" class="btn btn-secondary"
                                        disabled>Previous</button>
                                    <button type="button" id="nextBtn" class="btn btn-secondary">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        $(document).ready(function () {
                            let images = [];
                            let currentIndex = 0;

                            @foreach ($otherImages as $image)
                                images.push("{{ asset($image) }}");
                            @endforeach

                            $('#imageModal').on('show.bs.modal', function (event) {
                                const button = $(event.relatedTarget);
                                const imgSrc = button.data('img');
                                currentIndex = images.indexOf(imgSrc);
                                updateModalImage(imgSrc);
                                updateButtonState();
                            });

                            function updateModalImage(src) {
                                $('#modalImage').attr('src', src);
                            }

                            function updateButtonState() {
                                $('#prevBtn').prop('disabled', currentIndex === 0);
                                $('#nextBtn').prop('disabled', currentIndex === images.length - 1);
                            }

                            $('#prevBtn').click(function () {
                                if (currentIndex > 0) {
                                    currentIndex--;
                                    updateModalImage(images[currentIndex]);
                                    updateButtonState();
                                }
                            });

                            $('#nextBtn').click(function () {
                                if (currentIndex < images.length - 1) {
                                    currentIndex++;
                                    updateModalImage(images[currentIndex]);
                                    updateButtonState();
                                }
                            });
                        });
                    </script>

                    <!-- Property Details -->
                    <div class="col-md-8 d-flex justify-content-between pt-3 ">
                        <div class="flex">
                            <h3 class="md-text">{{ $properties->title }}</h3>
                            <h4 class="sm-text">
                                <i class="fa-solid fa-location-dot"></i>
                                <span>{{ $properties->street }}, {{ $properties->address->suburb }}, {{ $properties->address->state }}</span>
                            </h4>
                        </div>
                        <div class="d-flex py-2">
                            <!-- <div class="btn-buttonxs btn-buttonxsgreen mx-1">{{ $properties->status }}</div> -->
                            <div class="btn-buttonxs btn-buttonxsgreen">{{ $properties->availability_status }}</div>
                        </div>
                    </div>
                    <style>
                        .small-details {
                            border:1px solid rgba(0, 0, 0, 0.23);
                            padding: 0.3rem 1rem;
                            border-radius: 8px;

                        }

                        .detail-icon-dup {
                            font-size: 30px;
                        }
                    </style>
                    <!-- Overview and Description -->
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="">
                                    <h3 class="md-text greenhighlight">Overview</h3>
                                    <div class="d-flex flex-wrap gap-md-4 gap-3">
                                        <!-- <div class="col-2 small-details d-flex align-items-center justify-content-center flex-column">
                                        
                                            <i class="fa-solid fa-bed detail-icon"></i>
                                            <h2 class="sm-text">{{ $properties->update_time }}</h2>
                                        </div> -->
                                        <div
                                            class="col-md-2 col-5 small-details d-flex align-items-center justify-content-center flex-column">
                                            <i class="fa-solid fa-list detail-icon-dup mt-1"></i>
                                            {{-- <i class="fa-solid fa-house detail-icon-dup mt-1"></i> --}}
                                            <h2 class="sm-text">{{ $properties->category->title }}</h2>
                                        </div>
                                        <div
                                           class="col-md-2 col-5 small-details d-flex flex-column align-items-center justify-content-center gap-1 ">
                                            <i class="fa-solid fa-bed detail-icon-dup mt-1"></i>
                                            <h2 class="sm-text">{{ $properties->bedrooms }}</h2>
                                        </div>
                                        <div
                                             class="col-md-2 col-5 small-details d-flex align-items-center justify-content-center flex-column">
                                            <i class="fa-solid fa-bath detail-icon-dup mt-1"></i>
                                            <h2 class="sm-text">{{ $properties->bathrooms }}</h2>
                                        </div>
                                        <div
                                     class="col-md-2 col-5 small-details d-flex align-items-center justify-content-center flex-column">
                                            <i class="fa-solid fa-chart-area detail-icon-dup mt-1"></i>
                                           
                                            <h2 class="sm-text">{{ $properties->area }}</h2>
                                        </div>
                                        <div
                                             class="col-md-2 col-5 small-details d-flex align-items-center justify-content-center flex-column">
                                             <i class="fa-solid fa-money-check-dollar detail-icon-dup mt-1"></i>
                                           
                                            <h2 class="sm-text">{{ $properties->price }}</h2>
                                        </div>
                                    </div>
                                </div>
                                <!-- Property Description -->
                                <div class="description-body">
                                    <h3 class="md-text greenhighlight">Description</h3>
                                    <p class="sm-text">{{ $properties->description }}</p>
                                </div>
                                <!-- Additional Information -->
                                {{-- <div class="description-body">
                                    <h3 class="md-text greenhighlight">More Information if Any</h3>
                                    <p class="sm-text">{{ $properties->description }}</p>
                                </div> --}}



                                <div class="review mx-2">
                                    <h1 class="admire rounded p-3 md-text1 greenhighlight">We admire your review</h1>
                                    <div class="row gap-2">
                                        @forelse($acceptedReviews as $review)
                                            <div class="show-review col-md-12 m-1 p-3">
                                                <p class="p-0 m-0 md-text">{{ e($review->name) }}</p>
                                                <p class="p-0 m-0">
                                                    @for($i = 0; $i < $review->ratings; $i++)
                                                        <i class="fa-solid fa-star"></i>
                                                    @endfor
                                                </p>
                                                <p class="p-0 m-0 extra-text">{{ e($review->reviews) }}</p>
                                            </div>
                                        @empty
                                            <p class="col-md-12 m-1 p-3">No reviews yet for this property.</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                            <!-- Sidebar Details-->

                            <div class="col-md-4">
                                <div class="description-body">
                                    <h3 class="md-text greenhighlight">Nexon Detail Center</h3>
                                    <form action="{{ route('contact.store') }}" method="POST">
                                        @csrf
                                        <div class="d-flex flex-column gap-2">
                                            @auth
                                                <p class="text-muted">Any queries, {{ Auth::user()->name }}?
                                                    ({{ Auth::user()->email }})</p>
                                                <textarea name="message" class="textarea" placeholder="Your Message"
                                                    required></textarea>

                                                <!-- Conditional "Book an Inspection" shown only for logged-in users and if update_time is set -->
                                                @if($properties->update_time)
                                                    <div class="d-flex align-items-center my-3">
                                                        <input class="form-check-input me-2" type="checkbox" name="inspection"
                                                            id="update_time">
                                                        <label class="form-check-label fw-bold" for="update_time"
                                                            style="color: #28a745; font-weight: bold;">
                                                            Book an inspection (Available: {{ $properties->update_time }})
                                                        </label>
                                                    </div>
                                                @endif

                                                <input type="hidden" name="properties_id" value="{{ $properties->id }}">

                                                <button type="submit"
                                                    class="btn-buttongreen btn-buttonygreenlarge mx-2">Send Message</button>
                                            @else
                                                <!-- Fields for non-authenticated users -->
                                                <input type="text" name="name" class="input" placeholder="Person Name"
                                                    required>
                                                <input type="email" name="email" class="input my-2" placeholder="Email"
                                                    required>
                                                <textarea name="message" class="textarea" placeholder="Your Message"
                                                    required></textarea>

                                                <input type="hidden" name="properties_id" value="{{ $properties->id }}">

                                                <button type="submit"
                                                    class="btn-buttongreen btn-buttonygreenlarge mx-2">Submit</button>
                                            @endauth
                                        </div>
                                    </form>

                                </div>


                                <div class="paddingbox nobackground description-body">
                                    <h2 class="md-text">Feature List</h2>
                                    <div class="featurelist-body">
                                        @foreach ($relatedProperties as $property)
                                                                                <a class="featurelist-content d-flex py-1"
                                                                                    href="{{ route('singleproperties', ['id' => $property->id]) }}">
                                                                                    @php
                                                                                        $mainImages = !empty($property->main_image) ? json_decode($property->main_image, true) : [];
                                                                                        $mainImage = !empty($mainImages) ? asset($mainImages[0]) : asset('images/default-placeholder.png');
                                                                                    @endphp
                                                                                    <img src="{{ $mainImage }}" alt="Property Image" class="feature-smallimg"
                                                                                        data-src="holder.js/200x250?theme=thumb">
                                                                                    <div class="featurlist-description mx-3">
                                                                                        <h3 class="sm-text">{{ $property->title }}</h3>
                                                                                        <p class="sm-text highlight">{{ $property->price }}</p>
                                                                                    </div>
                                                                                </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid m-0 p-0">
        @if(Auth::check())
            <div class="review-form" style="display: none;">
                <div class="d-flex row justify-content-center">
                    <div class="col-md-5 p-5 review-form-detail" id="getviewform">
                        <i class="fa-solid fa-circle-xmark" onclick="closeFormFun()"></i>
                        <h2 class="md-text1">Rating</h2>
                        <div class="star-rating">
                            <i class="fa-solid fa-star" data-rating="1"></i>
                            <i class="fa-solid fa-star" data-rating="2"></i>
                            <i class="fa-solid fa-star" data-rating="3"></i>
                            <i class="fa-solid fa-star" data-rating="4"></i>
                            <i class="fa-solid fa-star" data-rating="5"></i>
                        </div>
                        <form id="reviewForm" action="{{ route('review.store') }}" method="POST">
                            @csrf
                            <input type="text" name="name" class="input" value="{{ Auth::user()->name }}" required readonly>
                            <input type="email" name="email" class="input my-2" value="{{ Auth::user()->email }}" required
                                readonly>
                            <textarea name="reviews" class="input my-2" placeholder="Your Message" required></textarea>
                            <input type="hidden" name="property_id" value="{{ $properties->id }}">
                            <input type="hidden" name="ratings" id="ratings-input" value="0">
                            <input type="hidden" name="status" value="pending">
                            <button type="submit" class="btn-buttonyellow mx-2">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="login-message overlay" style="display: none;">
                <div class="popup-content">
                    <i class="fa-solid fa-circle-xmark popup-close" onclick="closeLoginPopup()"></i>
                    <h2>Please Login First</h2>
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                </div>
            </div>
        @endif
    </div>

    <script>


        // For Reviews and Ratings

        document.addEventListener('DOMContentLoaded', function () {
            const stars = document.querySelectorAll('.star-rating .fa-star');
            const ratingInput = document.getElementById('ratings-input');
            let currentRating = 0;

            stars.forEach(star => {
                star.addEventListener('mouseover', function () {
                    const rating = this.getAttribute('data-rating');
                    highlightStars(rating);
                });

                star.addEventListener('mouseout', function () {
                    highlightStars(currentRating);
                });

                star.addEventListener('click', function () {
                    currentRating = this.getAttribute('data-rating');
                    ratingInput.value = currentRating;
                    highlightStars(currentRating);
                });
            });

            function highlightStars(rating) {
                stars.forEach(star => {
                    if (star.getAttribute('data-rating') <= rating) {
                        star.classList.add('active');
                    } else {
                        star.classList.remove('active');
                    }
                });
            }

            // Prevent form submission if no rating is selected
            document.getElementById('reviewForm')?.addEventListener('submit', function (e) {
                if (ratingInput.value === '0') {
                    e.preventDefault();
                    alert('Please select a rating before submitting.');
                }
            });
        });

        function openReviewfun() {
            @if(Auth::check())
                const reviewForm = document.querySelector(".review-form");
                reviewForm.style.display = reviewForm.style.display === "none" ? "block" : "none";
            @else
                const loginMessage = document.querySelector(".login-message");
                loginMessage.style.display = "block";
            @endif
        }

        function closeFormFun() {
            document.querySelector(".review-form").style.display = "none";
        }

        function closeLoginPopup() {
            document.querySelector(".login-message").style.display = "none";
        }
    </script>

    <style>
        .star-rating .fa-star {
            color: #ccc;
            cursor: pointer;
            transition: color 0.2s;
        }

        .star-rating .fa-star.active {
            color: #ffd700;
        }

        .login-message {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .popup-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            position: relative;
        }

        .popup-close {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }
    </style>



    @endsection