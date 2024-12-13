<section class="container-fluid landproperties py-5">
    <div class="container">
        <div class="d-flex flex-column title pb-2">
            <div class="xs-text1 dashline text-center">Trusted Real Estate Care</div>
            <div class="lg-text text-center">Find sales Properties</div>
            <div class="row city-container gap-4 py-2">
                @foreach ($suburbCounts as $suburbCount)
                    @php
                        $property = $suburbProperties[$suburbCount['suburb']] ?? null;
                    @endphp
                    @if ($property)
                        <div class="city-detail rounded m-0 p-0">
                            <a href="{{ route('properties', ['suburb' => $suburbCount['suburb']]) }}" class="city-detail-link" style="text-decoration: none; color: inherit; display: block;">
                                @php
                                    $mainImages = !empty($property->main_image) ? json_decode($property->main_image, true) : [];
                                    $mainImage = !empty($mainImages)
                                        ? asset('' . $mainImages[0])
                                        : asset('images/default-placeholder.png');
                                @endphp
                                <img src="{{ $mainImage }}" alt="" class="cityimage rounded m-0 p-0">
                                <div class="city-description d-flex flex-column justify-content-end align-items-center">
                                    <p class="sm-text1">{{ $suburbCount['suburb'] }}</p>
                                    <p class="sm-text1">{{ $suburbCount['count'] }} properties</p>
                                </div>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</section>
