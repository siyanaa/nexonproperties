@extends("frontend.layouts.master")
@section("content")
<!-- bannersection -->
<section class="container-fluid">
  <div class="row">
    <div class="col-md-12 p-0">
      <div class="carousel-inner mb-3">
        <div class="row d-flex">
          <div class="col-md-12 text-center d-flex flex-column justify-content-center align-items-center mb-2 ">
            <img src="{{ asset('image/contact.jpg') }}" alt="" srcset="" class="imagecontroller imagecontrollerheight imagecontrollerheightextra">
            <div class="flex bannercontentheight">
              <div class="bannercontentinnerheight ">
                <h4 class="lg-text1">Contact</h4>
                <h5 class="md-text1"><a href="">home</a> <i class="fa-solid fa-angle-right "></i>
                  <span class="highlight">contact</span>
                </h5>
              </div>
            </div>
          </div>
        </div>
      </div>
</section>
<!-- detailsection -->
<section class="container-fluid contact">
  <div class="container">
    <div class="row d-flex justify-content-center align-items-center gap-2">
      @foreach ($siteSettings as $siteSetting)
        <div class="col-md-3 greenbackground d-flex justify-content-center align-items-center p-3">
          <i class="fa-solid fa-location-dot customiconslarge"></i>
          <div class="information">
            <h2 class="md-text1">Office Address</h2>
            <h2 class="sm-text1">
              @if(is_array($addresses = json_decode($siteSetting->office_address, true)) && !empty($addresses))
              {{ implode(', ', $addresses) }}
          @else
              {{ $siteSetting->office_address ?? 'No address available' }}
          @endif
          
            
            </h2>
          </div>
        </div>
        <div class="col-md-3 greenbackground d-flex justify-content-center align-items-center p-3">
          <i class="fa-solid fa-envelope customiconslarge"></i>
          <div class="information">
            <h2 class="md-text1">Office Contact</h2>
            <h2 class="sm-text1">
            
              @if(is_array($contacts = json_decode($siteSetting->office_contact, true)) && !empty($contacts))
              {{ implode(', ', $contacts) }}
          @else
              {{ $siteSetting->office_contact ?? 'No contact available' }}
          @endif
          
            </h2>
          </div>
        </div>
        <div class="col-md-3 greenbackground d-flex justify-content-center align-items-center p-3">
          <i class="fa-solid fa-phone customiconslarge"></i>
          <div class="information">
            <h2 class="md-text1">Office Email</h2>
            <h2 class="sm-text1">
              {{-- @if(is_array(json_decode($siteSetting->office_email, true)))
                {{ implode(', ', json_decode($siteSetting->office_email)) }}
              @else
                {{ $siteSetting->office_email }}
              @endif --}}



              @if(is_array($email = json_decode($siteSetting->office_email, true)) && !empty($email))
              {{ implode(', ', $email) }}
          @else
              {{ $siteSetting->office_email?? 'No email available' }}
          @endif
          

            </h2>
          </div>
        </div>
      @endforeach

    </div>
  </div>
</section>
<section class="container-fluid  my-5 form-map py-4 ">
  <div class="row d-flex  justify-content-center align-items-center mx-2">
    <div class="col-md-4 contentbackground px-4 m-2">
      <div class="d-flex flex-column gap-2">
        <p class="extra-small-text1">Ready to find your dream property or need assistance with buying, selling, or renting?
          Reach out to us today! Our team of real estate experts is here to guide you through every step of your journey. Whether you're looking for your next home or a prime investment opportunity, we’re just a message away.
          
          Contact us and let's make your real estate goals a reality!</p>
        <div class="d-flex flex-column">
          <label for="" class="xs-text pb-1">Your full Name</label>
          <input type="text" name="" id="" class="input" placeholder="Your Full name" />
        </div>
        <div class="d-flex flex-column">
          <label for="" class="xs-text pb-1">Email Address</label>
          <input type="text" name="" id="" class="input" placeholder="Your Email Address" />
        </div>
        <div class="d-flex flex-column">
          <label for="" class="xs-text pb-1">Message</label>
          <textarea name="" id="" class="textarea" placeholder="message"></textarea>
        </div>
        <button class="btn-buttonyellow btn-buttonyellowlarge mt-1 ">Send</button>
      </div>
    </div>
    <div class="col-md-6">
      <img src="{{asset("image/map.png")}}" alt="" class="contactbodyimage">
    </div>
  </div>
</section>
@endsection
<script>
  function funmenu() {
    const burmenu = document.getElementById("bur-menu");
    if (burmenu.style.display === "block") {
      burmenu.style.display = "none";
    } else {
      burmenu.style.display = "block";
    }
  }
</script>