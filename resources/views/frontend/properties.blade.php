@extends('frontend.layouts.master')
@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12 p-0">
                <div class="carousel-inner mb-3">
                    <div class="row d-flex">
                        <div
                            class="col-md-12 text-center d-flex flex-column justify-content-center align-items-center mb-2 ">
                            <img src="{{ asset('image/house3.png') }}" alt="" srcset=""
                                class="imagecontroller imagecontrollerheight">
                            <div class="flex bannercontentheight">
                                <div class="bannercontentinnerheight ">
                                    <h4 class="lg-text1">properties</h4>
                                    <h5 class="md-text1">home <i class="fa-solid fa-angle-right "></i>
                                        <span class="highlight">properties</span>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </section>

    {{--


<form action="{{ route('frontend.searching') }}" method="GET" class="container-fluid py-5 propertiesfinder">
    <div class="container">
        <h1 class="md-text1 text-center searchhide" onclick="funsearchingon()">
            <i class="fa-brands fa-searchengin customicons"></i> Find your properties
        </h1>
        <div class="justify-content-center align-items-center gap-2 flex-wrap hiddenform" id="hiddenform">

        <div class="d-flex flex-column col-md-3">
                    <label for="" class="sm-text1 des-text">Keyword</label>
                  <input type="text" class="input bannerinput" name="location" placeholder="Keyword"
                  value="{{ request('location') }}">
                </div>


                <div class="d-flex flex-column col-md-3">
                    <label for="" class="sm-text1 des-text">Listing type</label>
                    <select class="input bannerinput" name="category_id" id="category_id">
                        <option value="" disabled selected>Select Category</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex flex-column col-md-3">
                    <label for="" class="sm-text1 des-text">Select Category</label>
                  <select class="input bannerinput" name="subcategory_id" id="subcategory_id">
                    <option value="" disabled selected>Select Subcategory</option>
                  </select>
                </div>
                <div class="d-flex flex-column col-md-3">
                    <label for="" class="sm-text1 des-text">Select State</label>
                  <select class="input bannerinput" name="state" id="state">
                    <option value="" disabled selected>Select State</option>
                    @foreach ($states as $state)
                      <option value="{{ $state }}">{{ $state }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="d-flex flex-column col-md-3">
                    <label for="" class="sm-text1 des-text">Select Region</label>
                  <select class="input bannerinput" name="suburb" id="suburb">
                    <option value="" disabled selected>Select Region</option>
                  </select>
                </div>
                
                <span class="sm-text mt-2 whitehighlight advance mx-2" onclick="funOpenadvance()">Advanced ::</span>
            <div class="d-flex flex-column col-md-3">
                <label for="" class="sm-text1 des-text">Search</label>
                <button type="submit" class="btn-buttonyellow ">Searsch</button>
            </div>

        </div>
    </div>
</form>
  


--}}



    @include('frontend.include.searchbox')


    <!-- multiple properties section -->
    <section class="container-fluid multipost mb-3 pb-4">
        <div class="container">
            <div class="row ">
                {{-- <div class="col-md-12">
              <div class="property-container d-flex justify-content-center align-self-center gap-3 flex-wrap">
                  <div class="btn-buttongreen"> <i class="fa-solid fa-house customicons customiconssmall"></i> sale
                  </div>
                  <div class="btn-buttongreen"> <i class="fa-solid fa-house customicons customiconssmall"></i> Condos
                  </div>
                  <div class="btn-buttongreen "> <i class="fa-solid fa-house customicons customiconssmall"></i> sale
                  </div>
                  <div class="btn-buttongreen "> <i class="fa-solid fa-house customicons customiconssmall"></i> Condos
                  </div>
                  <div class="btn-buttongreen "> <i class="fa-solid fa-house customicons customiconssmall"></i> sale
                  </div>
              </div>
          </div> --}}
                <div class="col-md-12 py-3">
                    <div class="row">
                        @foreach ($properties as $property)
                            <a class="col-md-4 my-2" href="{{ route('singleproperties', ['id' => $property->id]) }}">
                                <div class="card">
                                    @php
                                        $mainImages = !empty($property->main_image)
                                            ? json_decode($property->main_image, true)
                                            : [];
                                        $mainImage = !empty($mainImages)
                                            ? asset('' . $mainImages[0])
                                            : asset('images/default-placeholder.png');
                                    @endphp
                                    <img src="{{ $mainImage }}" alt="Property Image" class="p-2">
                                    <div class="sell_rent_button d-flex justify-content-between ">
                                        <div class="btn-buttonxs btn-buttonxsyellow ">{{ $property->status }}</div>
                                        <div class="btn-buttonxs btn-buttonxsgreen mx-1">
                                            {{ $property->availability_status }}
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="md-text">
                                            {{ strlen($property->title) > 28 ? substr($property->title, 0, 28) . '...' : $property->title }}
                                        </h5>

                                        <p><i class="fa-solid fa-location-dot mx-2"></i> {{ $property->street }},
                                            {{ $property->address->suburb }}, {{ $property->address->state }}</p>

                                        <div class="row justify-content-between">
                                            <div class="col text-start">
                                                <h2 class="sm-text"><i class="fa-solid fa-bed detail-icon"></i> <span
                                                        class="mx-1">{{ $property->bedrooms }}</span></h2>
                                            </div>
                                            <div class="col text-center">
                                                <h2 class="sm-text"><i class="fa-solid fa-bath detail-icon"></i> <span
                                                        class="mx-1">{{ $property->bathrooms }}</span></h2>
                                            </div>
                                            <div class="col text-end">
                                                <h2 class="sm-text"><i class="fa-solid fa-chart-area detail-icon"></i> <span
                                                        class="mx-1">{{ $property->price }}</span></h2>
                                            </div>
                                        </div>

                                        <div class="price-person ">
                                            <div class="d-flex justify-content-between align-content-center">
                                                <div class=" sm-text"> <span class="md-text"> ${{ $property->price }}
                                                        /</span>{{ $property->rental_period }} </div>

                                                    @php
                                                        $limitedImages = array_slice($otherImages, 0, 6);
                                                    @endphp
                                                  
                                                            @foreach ($limitedImages as $index => $image)
                                                               
                                                                    <img src="{{ asset($image) }}" alt="Property Image"
                                                                        class="feature-smallimg feature-smallimgdup">
                                                          
                                                            @endforeach
                                                    

                                                {{-- <img src="{{ asset('image/blog.png') }}" alt="" sizes=""
                                                    srcset="" class="feature-smallimg feature-smallimgdup"> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>




    <!-- nextpage section -->
    {{-- 
<section class="container-fluid">
    <div class="container">
        <div class="row  nextpage ">



            <ul class="nextui d-flex gap-1 justify-content-center align-content-center flex-wrap">
                <li class="nextli next-button" onclick="changepage(this)"><a href="#" class="md-text1">1</a></li>
                <li class="nextli" onclick="changepage(this)"><a href="#" class="md-text1">2</a></li>
                <li class="nextli" onclick="changepage(this)"><a href="#" class="md-text1">3</a></li>
                <li class="nextli" onclick="changepage(this)"><a href="#" class="md-text1">4</a></li>
                <li class="nextli" onclick="changepage(this)"><a href="#" class="md-text1">5</a></li>
            </ul>
        </div>
    </div>
</section> --}}
@endsection


<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const amenitiesCheckboxes = document.querySelectorAll('.amenity-checkbox');
        const searchForm = document.querySelector('form[action="{{ route('frontend.searching') }}"]');

        function updateSearch() {
            const selectedAmenities = Array.from(amenitiesCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);

            searchForm.querySelectorAll('input[name="amenities[]"]').forEach(input => input.remove());

            selectedAmenities.forEach(amenityId => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'amenities[]';
                input.value = amenityId;
                searchForm.appendChild(input);
            });

            ['bedrooms', 'bathrooms', 'min_area', 'max_area', 'min_price', 'max_price'].forEach(filterName => {
                const filterElement = document.getElementById(filterName);
                if (filterElement) {
                    const filterValue = filterElement.value;
                    searchForm.querySelector(`input[name="${filterName}"]`)?.remove();

                    if (filterValue) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = filterName;
                        input.value = filterValue;
                        searchForm.appendChild(input);
                    }
                }
            });
        }

        amenitiesCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSearch);
        });

        // Attach event listeners to all filters
        ['bedrooms', 'bathrooms', 'min_area', 'max_area', 'min_price', 'max_price'].forEach(filterName => {
            const filterElement = document.getElementById(filterName);
            if (filterElement) {
                filterElement.addEventListener('change', updateSearch);
            }
        });

        function funOpenadvance() {
            const advanceItems = document.querySelector(".amenities");
            if (!advanceItems) {
                console.error("Element with class 'amenities' not found.");
                return;
            }
            advanceItems.style.display = advanceItems.style.display === "none" ? "block" : "none";
        }

        const advanceSearchButton = document.querySelector('.advance');
        if (advanceSearchButton) {
            advanceSearchButton.addEventListener('click', funOpenadvance);
        }

        // Initialize Area Slider
        $("#area-slider").slider({
            range: true,
            min: 0,
            max: 10000,
            values: [0, 10000],
            slide: function(event, ui) {
                updateAreaDisplay(ui.values[0], ui.values[1]);
            },
            change: updateSearch
        });

        function updateAreaDisplay(minArea, maxArea) {
            $("#area-range-display").text(minArea.toLocaleString() + " - " + maxArea.toLocaleString() +
                " sq. ft.");
            $("#min_area").val(minArea);
            $("#max_area").val(maxArea);
        }

        // Initialize the area display
        updateAreaDisplay($("#area-slider").slider("values", 0), $("#area-slider").slider("values", 1));

        // Initialize Price Slider
        $("#price-slider").slider({
            range: true,
            min: 0,
            max: 1000000,
            values: [0, 1000000],
            slide: function(event, ui) {
                updatePriceDisplay(ui.values[0], ui.values[1]);
            },
            change: updateSearch // Add this line to trigger updateSearch on slider change
        });

        function updatePriceDisplay(minPrice, maxPrice) {
            $("#price-range-display").text("$" + minPrice.toLocaleString() + " - $" + maxPrice
        .toLocaleString());
            $("#min_price").val(minPrice);
            $("#max_price").val(maxPrice);
        }

        // Initialize the price display
        updatePriceDisplay($("#price-slider").slider("values", 0), $("#price-slider").slider("values", 1));

        // Update hidden inputs when form is submitted
        searchForm.addEventListener('submit', function(e) {
            updateSearch(); // Ensure all current values are included
        });
    });
</script>


<script>
    $(document).ready(function() {
        $('#category_id').change(function() {
            var categoryId = $(this).val();
            if (categoryId) {
                $.ajax({
                    url: '/get-subcategories/' + categoryId,
                    type: 'GET',
                    success: function(data) {
                        $('#subcategory_id').empty();
                        $('#subcategory_id').append(
                            '<option value="" disabled selected>Select Subcategory</option>'
                            );
                        $.each(data, function(key, value) {
                            $('#subcategory_id').append('<option value="' + value
                                .id + '">' + value.title + '</option>');
                        });
                    }
                });
            } else {
                $('#subcategory_id').empty();
                $('#subcategory_id').append(
                    '<option value="" disabled selected>Select Subcategory</option>');
            }
        });

        $('#state').change(function() {
            var state = $(this).val();
            if (state) {
                $.ajax({
                    url: '/get-suburbs/' + state,
                    type: 'GET',
                    success: function(data) {
                        $('#suburb').empty();
                        $('#suburb').append(
                            '<option value="" disabled selected>Select Region</option>');
                        $.each(data, function(key, value) {
                            $('#suburb').append('<option value="' + value + '">' +
                                value + '</option>');
                        });
                    }
                });
            } else {
                $('#suburb').empty();
                $('#suburb').append('<option value="" disabled selected>Select Region</option>');
            }
        });
    });
</script>


<script>
    function funsearchingon() {
        const hiddenformdata = document.querySelector(".hiddenform");

        // Toggle the display style
        if (hiddenformdata.style.display === "none" || hiddenformdata.style.display === "") {
            hiddenformdata.style.display = "block";
        } else {
            hiddenformdata.style.display = "none";
        }
    }

    function changepage(clickedElement) {
        // Remove 'next-button' class from all list items
        const allButtons = document.querySelectorAll('.nextli');
        allButtons.forEach(button => button.classList.remove('next-button'));

        // Add 'next-button' class to the clicked list item
        clickedElement.classList.add('next-button');
    }
</script>
