<section class="container-fluid navsection">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light navcustom">
            <a class="navbar-brand" href="/"> <img src="{{ asset('image/logo.png') }}" alt="Logo"
                    class="logoimg" /></a>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                      <ul class="navbar-nav mb-2 mb-lg-0 mx-auto">
                          @foreach ($categories as $category)
                              <li class="nav-item dropdown {{ request('categoryId') == $category->id ? 'active' : '' }}">
                                  <!-- Category link (clickable) -->
                                  <a class="nav-link" href="{{ route('properties', ['categoryId' => $category->id]) }}"
                                      id="navbarDropdown{{ $category->id }}" role="button">
                                      {{ $category->title }}
                                  </a> 
      
                                  <!-- Check if category has subcategories -->
                                  @if ($category->subcategories->count() > 0)
                                      <ul class="dropdown-menu" aria-labelledby="navbarDropdown{{ $category->id }}">
                                          @foreach ($category->subcategories as $subcategory)
                                              <li>
                                                  <a class="dropdown-item"
                                                      href="{{ route('properties', ['categoryId' => $category->id, 'subcategoryId' => $subcategory->id]) }}">
                                                      {{ $subcategory->title }}
                                                  </a>
                                              </li>
                                          @endforeach
                                      </ul>
                                  @endif
                              </li>
                          @endforeach
                      </ul>
                  </div>

            <div class="button-collection d-flex flex-column justify-content-center top">
                @guest
                    <div class="upper-login">
                        <a href="{{ route('register') }}"
                            class="btn-buttonyellow reg-logbutton reg-logbutton-white mb-1">Register</a>
                        <a href="{{ route('login') }}" class="btn-buttonyellow reg-logbutton">Login</a>
                    </div>
                @else
                    <span class="welcome-message sm-text1 upperlogout"> {{ Auth::user()->name }}</span>
                    {{-- <a href="{{ route('profile') }}" class="btn-buttonyellow reg-logbutton">Profile</a> --}}
                    <div class="d-flex">
                        <div class="upperlogout">
                            <a href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="btn-buttonyellow reg-logbutton">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf

                        </div>
                        <a href="{{ route('favourite') }}" class="d-flex fav mainitems-fav">
                            <p class="sm-text1 counter">1</p>
                            <i class="fa-solid fa-heart "></i>
                        </a>
                    </div>
                    </form>

                @endguest
            </div>

            <i class="customicons crossmenu mx-4 p-1 m-0 d-flex" onclick="funmenu()">
                <div class="linea line1"></div>
                <div class="linea line2"></div>
                <div class="linea line3"></div>
            </i>

        </nav>
    </div>
    <div class="bur-menu py-3" id="bur-menu">
        <div class="activites">
            <h2 class="navdestext pt-3">Activities Section</h2>
            <li class="nav-item">
                <i class="fa-solid fa-house customiconssmall"></i>
                <a class="nav-link" aria-current="page" href="/">Introduction</a>
            </li>
            <li class="nav-item">
                <i class="fa-solid fa-truck-moving customiconssmall"></i>
                <a class="nav-link" aria-current="page" href="{{ route('properties') }}">Rent</a>
            </li>
            <li class="nav-item">
                <i class="fa-solid fa-cart-shopping customiconssmall"></i>
                <a class="nav-link" aria-current="page" href="{{ route('properties') }}">Buy</a>
            </li>
        </div>
        <div class="information">
            <h2 class="navdestext">Information Section</h2>
            <li class="nav-item d-flex">
                <i class="fa-solid fa-circle-question customiconssmall"></i>
                <a class="nav-link" aria-current="page" href="{{ route('about') }}">About</a>
            </li>
            <li class="nav-item">
                <i class="fa-solid fa-blog customiconssmall"></i>
                <a class="nav-link active" aria-current="page" href="{{ route('blog') }}">Blog</a>
            </li>
            <li class="nav-item">
                <i class="fa-solid fa-address-book customiconssmall"></i>
                <a class="nav-link active" aria-current="page" href="{{ route('contact') }}">Contact</a>
            </li>
        </div>
        <h2 class="navdestext">Follow Us</h2>
        <div class="d-flex font-collection py-2">
            <a href="{{ $sitesetting->socialLinks->facebook_link }}" target="_blank"><i class="fa-brands fa-facebook customicons mx-2"></i></a>
            <a href="{{ $sitesetting->socialLinks->linkedin_link }}" target="_blank"><i class="fa-brands fa-linkedin customicons mx-2"></i></a>
            <a href="{{ $sitesetting->socialLinks->instagram_link }}" target="_blank"><i class="fa-brands fa-instagram customicons mx-2"></i></a>
            <a href="{{ $sitesetting->socialLinks->tiktop_link }}" target="_blank"><i class="fa-brands fa-youtube customicons mx-2"></i></a>

        </div>
        <div class="button-collection d-flex justify-content-center align-items-center logoutsection">
            @guest
                <div class="sidenav-login">
                    <a href="{{ route('register') }}"
                        class="btn-buttonyellow reg-logbutton reg-logbutton-white mb-1">Register</a>
                    <a href="{{ route('login') }}" class="btn-buttonyellow reg-logbutton">Login</a>
                </div>
            @else
                <div class="d-flex gap-1  justify-content-center align-items-center">
                    <img src="{{ asset('image/about.jpg') }}" alt="" class="userimage">
                    <span class="welcome-message sm-text1 text-center"> {{ Auth::user()->name }}</span>
                </div>
                {{-- <a href="{{ route('profile') }}" class="btn-buttonyellow reg-logbutton">Profile</a> --}}
                <div class="d-flex ">
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="btn-buttonyellow  mx-3 logout">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf


                </div>
                </form>

            @endguest
        </div>






    </div>


</section>
<script>
    // Menu Toggle Function
    function funmenu() {
        const menuIcon = document.querySelector('.crossmenu');
        const menu = document.getElementById('bur-menu');

        // Toggle the 'cross' class on the menu icon
        menuIcon.classList.toggle('cross');

        // Toggle the display of the menu
        if (menu.style.display === "block") {
            menu.style.display = "none";
        } else {
            menu.style.display = "block";
        }
    }

    // Search Form Toggle Function
    function funsearchingon() {
        const hiddenformdata = document.getElementsByClassName("hiddenform")[0];
        hiddenformdata.style.display = hiddenformdata.style.display === "block" ? "none" : "block";
    }

    // Scroll Behavior
    let lastScrollY = window.scrollY;
    const navSection = document.querySelector('.navsection');

    function handleScroll() {
        if (window.scrollY > lastScrollY) {
            // Scrolling down
            navSection.style.top = '2rem';
        } else {
            // Scrolling up
            navSection.style.top = '0'; // Adjust as needed
        }
        lastScrollY = window.scrollY;
    }

    function checkScreenSize() {
        if (window.innerWidth < 900) {
            window.addEventListener('scroll', handleScroll);
        } else {
            // Remove the scroll event listener if the screen size is larger than 900px
            window.removeEventListener('scroll', handleScroll);
            navSection.style.top = ''; // Reset top style
        }
    }

    // Initial check
    checkScreenSize();

    // Check again on resize
    window.addEventListener('resize', checkScreenSize);

    function funmenu() {
        const menuIcon = document.querySelector('.crossmenu');
        const menu = document.getElementById('bur-menu');

        // Toggle the 'cross' class on the menu icon
        menuIcon.classList.toggle('cross');

        // Toggle the display of the menu
        if (menu.style.display === "block") {
            menu.style.display = "none";
        } else {
            menu.style.display = "block";
        }
    }

    function funsearchingon() {
        const hiddenformdata = document.getElementsByClassName("hiddenform")[0];
        hiddenformdata.style.display = hiddenformdata.style.display === "block" ? "none" : "block";
    }
</script>
