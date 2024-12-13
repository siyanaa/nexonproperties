@extends('frontend.layouts.master')

{{--navbar --}}
@section("content")

{{--bannersection --}}
@include("frontend.include.indexbanner")

{{--advantage --}}
@include("frontend.include.advantage")

{{--description about company --}}
@include("frontend.include.about")

{{--our properties --}}
@include("frontend.include.project")


@include("frontend.include.landproperties");

{{-- @includeIf("frontend.include.counter") --}}
{{-- <!-- testimonial --> --}}
@include("frontend.include.testimonial")

{{--blog --}}
@include("frontend.include.blog")


@endsection






{{--<!-- connect us --> --}}

{{--
<section class="container-fluid connect my-4 position-relative">
  <div class="overlay-image" style="background-image: url('{{ asset('image/abb.png') }}');"></div>
  <div class="overlay"></div>
  <div class="container  connectbody">
    <div class="row d-flex justify-content-between">
      <div class="col-md-5">
        <h3 class="md-text1">Let’s Connect with Us</h3>
        <p class="sm-text1">Pará is a state of Brazil, located in northern Brazil and traversed by the lower Amazon
          River.</p>
      </div>
      <div class="col-md-2">
        <h6 class="md-text1">Call Us</h6>
        <h6 class="sm-text1">979-93333-33</h6>
        <a href="https://www.youtube.com/">
          <button class="btn-buttonyellow">Visit Us</button>
        </a>
      </div>
    </div>
  </div>
</section>
--}}

{{-- <!-- blog section --> --}}





{{--footer section --}}