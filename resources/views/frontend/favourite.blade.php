@extends('frontend.layouts.master')
@section("content")
<section class="singlepage pt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <style>
                    .delted:hover{
                        background: red;
                    }
                </style>
        
                <div class="row">
            @foreach ($properties as $property)
          
                                        <a class="col-md-5 my-2" href="{{route('singleproperties', ['id' => $property->id])}}">
                                    
                                            <div class="card deletecard">    
                                            <i class="fa-solid fa-trash delted" onclick="deletefav(this)"></i>                                   
                                                @php
                                                    $mainImages = !empty($property->main_image) ? json_decode($property->main_image, true) : [];
                                                    $mainImage = !empty($mainImages) ? asset('' . $mainImages[0]) : asset('images/default-placeholder.png');
                                                 @endphp
                                                <img src="{{ $mainImage }}" alt="Property Image" class="p-2">
                                                <div class="sell_rent_button d-flex justify-content-between ">
                                                    <div class="btn-buttonxs btn-buttonxsyellow ">{{$property->status}}</div>
                                                    <div class="btn-buttonxs btn-buttonxsgreen mx-1">{{$property->availability_status}}
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="md-text">{{strlen($property->title)>28 ? substr($property->title ,0 ,28). "...":$property->title }}</h5>
                                                    <div class=" d-flex gap-3 flex-wrap ">
                                                        <h2 class="sm-text"><span class="mx-1">{{ $property->bedrooms}}</span> bedroom</h2>
                                                        <h2 class="sm-text"><span class="mx-1">{{ $property->bathrooms}}</span>bathroom</h2>
                                                        <h2 class="sm-text"><span class="mx-1">{{ $property->price}}</span>area</h2>
                                                    </div>
                                                    <div class="price-person ">
                                                        <div class="d-flex justify-content-between align-content-center">
                                                            <div class=" sm-text"> <span class="md-text"> ${{ $property->price}}
                                                                    </span>{{ $property->rental_period}} </div>
                                                            <img src="{{asset('image/blog.png')}}" alt="" sizes="" srcset=""
                                                                class="feature-smallimg feature-smallimgdup">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                    @endforeach
                    </div>
            </div>
            <div class="col-md-4 sidebar  ">
                <div class="paddingbox">
                    <input type="text" name="" id="" class="input">
                </div>
                <div class="paddingbox ">
                    <h2 class="md-text1">Recent post</h2>
                    <ul class="customui">
                        @foreach ($properties as $property)
                            <li class="py-1">
                                <a href="#" class="md-text"> <i
                                        class="fa-solid fa-hand-point-right customicons customiconssmall "></i>
                                    {{$property->title}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="paddingbox nobackground">
                    <h2 class="md-text">feature list</h2>
                    <div class="featurelist-body">
                        @foreach ($properties as $property)
                                                <a class="featurelist-content d-flex py-1"
                                                    href="{{route('singleproperties', ['id' => $property->id])}}">
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

    function deletefav(icon) {
    const card = icon.closest('.deletecard');
    if (card) {
        card.remove();
    }
}


</script>