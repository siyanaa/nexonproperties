@extends('frontend.layouts.master')
@section("content")



<section class="singlepage pt-4">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <div class="row d-flex flex- col ">
          <div class="col-md-12 mb-3">
            @php
        $images = json_decode($blogs->image, true); // Decode the JSON array into a PHP array
      @endphp
            @if (!empty($images))
        @foreach ($images as $image)
      <img class="imagecontroller imagecontrollermd" src="{{ asset('storage/blog_images/' . basename($image)) }}"
        alt="Blog image">
    @endforeach
      @else
    <p>No images available</p>
  @endif
            <div class=" d-flex gap-3 py-3">
              <div class="d-flex ">
                <i class="fa-solid fa-person customiconssmall pt-1 mx-1"></i>
                <h2 class="sm-text">Real</h2>
              </div>
              <div class="d-flex ">
                <i class="fa-solid fa-calendar-days customiconssmall pt-1 mx-1"></i>
                <h2 class="sm-text text-center">june 8,2024</h2>
              </div>
              <div class="d-flex">
                <i class="fa-solid fa-building customiconssmall pt-1 mx-1"></i>
                <h2 class="sm-text">type</h2>
              </div>
            </div>
            <h5 class="md-text"> {{$blogs->title}} </h5>
            <p class="sm-text py-1">{{$blogs->description}}
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-4 sidebar  ">
        <div class="paddingbox ">
          <h2 class="md-text1">Recent post</h2>
          <ul class="customui">
            @foreach ($relatedPosts as $blog)
        <li class="py-1"><a href="" class="md-text"> <i
            class="fa-solid fa-hand-point-right customicons customiconssmall "></i>
          {{$blog->title}}
          </a></li>
      @endforeach
          </ul>
        </div>
        <div class="paddingbox nobackground">
          <h2 class="md-text">feature list</h2>
          <div class="featurelist-body">
            @foreach ($properties as $property)
              <a class="featurelist-content d-flex py-1" href="{{route('singleproperties', ['id' => $property->id])}}">
                @php
            $mainImages = !empty($property->main_image) ? json_decode($property->main_image, true) : [];
            $mainImage = !empty($mainImages) ? asset('' . $mainImages[0]) : asset('images/default-placeholder.png');
         @endphp
                <img src="{{ $mainImage }}" alt="Property Image" class="feature-smallimg"
                data-src="holder.js/200x250?theme=thumb" />
                <div class="featurlist-description mx-3">
                <h3 class="sm-text">{{$property->title}}</h3>
                <p class="sm-text highlight"> {{$property->price}}</p>
                </div>
              </a>
      @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



@endsection
<!-- each team des -->
<!-- banner section -->


<script>

  function changepage(element) {
    const pageli = document.getElementsByClassName("nextli");
    for (let i = 0; i < pageli.length; i++) {
      pageli[i].classList.remove("activeli");

    }

    element.classList.add("activeli")
  }
</script>