

<form action="{{ route('frontend.searching') }}" method="GET" id="propertySearchForm">
    <div class="formsection flex-column justify-content-center align-items-center py-md-3 py-2 gap-2 col-md-12 px-4 ">
        <div class="d-flex flex-wrap gap-md-3 showform">
            <input type="text" class="input bannerinput" name="location" placeholder="Keyword"
                value="{{ request('location') }}">
            <select class="input bannerinput" name="category_id" id="category_id">
                <option value="" disabled selected>Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                @endforeach
            </select>
            <select class="input bannerinput" name="subcategory_id" id="subcategory_id">
                <option value="" disabled selected>Select Subcategory</option>
            </select>
            <select class="input bannerinput" name="state" id="state">
                <option value="" disabled selected>Select State</option>
                @foreach ($states as $state)
                    <option value="{{ $state }}">{{ $state }}</option>
                @endforeach
            </select>
            <select class="input bannerinput" name="suburb" id="suburb">
                <option value="" disabled selected>Select Region</option>
            </select>

            <span class="sm-text mt-2 greenhighlight advance mx-2" onclick="funOpenadvance()">Advanced ::</span>
            <button type="submit" class="btn-buttongreen">Search</button>
        </div>
    </div>
</form>

<section class="container rounded amenities py-2" width="100%">
    <div class="row p-3" id="advanceitems">
        <h2 class="md-text greenhighlight mx-2">amenities</h2>
        <!-- Amenity Checkboxes -->
        @foreach ($amenities as $amenity)
            <div class="d-flex col-md-2 pt-1">
                <input type="checkbox" name="amenities[]" id="amenity-{{ $amenity->id }}" value="{{ $amenity->id }}"
                    {{ in_array($amenity->id, request('amenities', [])) ? 'checked' : '' }} class="amenity-checkbox">
                <label for="amenity-{{ $amenity->id }}" class="nameofthing">{{ $amenity->title }}</label>
            </div>
        @endforeach
    </div>

    <!-- Bedrooms, Bathrooms, Area, and Price Section -->
    <div class="row mx-2 d-flex justify-content-between gap-1">
        <div class="col-md-3">
            <label for="bedrooms" class="sm-text">Bedrooms</label>
            <select name="bedrooms" id="bedrooms" class="input bannerinput">
                <option value="" selected>Beds Any</option>
                @for ($i = 1; $i <= 10; $i++)
                    <option value="{{ $i }}" {{ request('bedrooms') == $i ? 'selected' : '' }}>
                        {{ $i }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-3">
            <label for="bathrooms" class="sm-text">Bathrooms</label>
            <select name="bathrooms" id="bathrooms" class="input bannerinput">
                <option value="" selected>Baths Any</option>
                @for ($i = 1; $i <= 10; $i++)
                    <option value="{{ $i }}" {{ request('bathrooms') == $i ? 'selected' : '' }}>
                        {{ $i }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-3">
            <label for="area-range" class="md-text">Area (sq. ft.)</label>
            <div id="area-slider" class="mt-2"></div>
            <span id="area-range-display" class="sm-text d-block mt-2"></span>
            <input type="hidden" name="min_area" id="min_area">
            <input type="hidden" name="max_area" id="max_area">
        </div>
        <div class="col-md-3">
            <label for="price-range" class="md-text">Price</label>
            <div id="price-slider" class="mt-2 price-slider"></div>
            <span id="price-range-display" class="sm-text d-block mt-2"></span>
            <input type="hidden" name="min_price" id="min_price">
            <input type="hidden" name="max_price" id="max_price">
        </div>
    </div>

</section>
<style>
    .ui-slider-horizontal {
        height: 8px;
    }

    .ui-slider .ui-slider-handle {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        top: -5px;
        cursor: pointer;
    }
</style>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">



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
                  url: '/get-suburbs-by-state/' + encodeURIComponent(state),
                  type: 'GET',
                  success: function(data) {
                      $('#suburb').empty();
                      $('#suburb').append(
                          '<option value="" disabled selected>Select Region</option>');
                      $.each(data, function(key, value) {
                          $('#suburb').append('<option value="' + value + '">' +
                              value + '</option>');
                      });
                  },
                  error: function(xhr, status, error) {
                      console.error("Error fetching suburbs:", error);
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
            change: updateSearch
        });

        function updatePriceDisplay(minPrice, maxPrice) {
            $("#price-range-display").text("$" + minPrice.toLocaleString() + " - $" + maxPrice
        .toLocaleString());
            $("#min_price").val(minPrice);
            $("#max_price").val(maxPrice);
        }


        updatePriceDisplay($("#price-slider").slider("values", 0), $("#price-slider").slider("values", 1));

        searchForm.addEventListener('submit', function(e) {
            updateSearch();
        });
    });
</script>
