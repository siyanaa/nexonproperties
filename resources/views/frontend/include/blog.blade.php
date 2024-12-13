<section class="container-fluid gapbetweensection">
  <div class="container">
    <div class="row mb-4">
      <div class="col-12">
        <div class="title text-center">
          <div class="xs-text1 dashline">Trusted Real Estate Care</div>
          <div class="lg-text">Latest BLOG for you</div>
        </div>
      </div>
    </div>
    <div class="swiper">
      <!-- Additional required wrapper -->
      <div class="swiper-wrapper">
        @foreach ($blogs as $blog)
          <div class="swiper-slide">
            <div class="card my-1">
              @php
                $images = json_decode($blog->image, true); // Decode the JSON array into a PHP array
              @endphp
              @if (!empty($images))
                @foreach ($images as $image)
                  <img class="card-img-top img-fluid" src="{{ asset('storage/blog_images/' . basename($image)) }}" alt="Blog image">
                @endforeach
              @else
                <p>No images available</p>
              @endif
              <div class="card-body">
                <h5 class="md-text">{{ $blog->title }}</h5>
                <p class="sm-text">
                  {{ strlen($blog->description) > 150 ? substr($blog->description, 0, 150) . '...' : $blog->description }}
                </p>
                <a href="{{ route('singleblogpost', ['slug' => $blog->metadata->slug]) }}" class="btn-buttongreen">Read more</a>
              </div>
            </div>
          </div>
    @endforeach
      </div>
    </div>
  </div>
</section>


