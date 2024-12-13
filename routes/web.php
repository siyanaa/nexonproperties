<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\MetadataController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\FrontViewController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\NoTransactionPurposeController;
use App\Http\Controllers\OffenderController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TranPurposeController;
use App\Http\Controllers\TranProofController;
use App\Http\Controllers\TranNatureController;
use App\Http\Controllers\HistoriesController;
use App\Models\Blog;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SingleController;
use App\Http\Controllers\Admin\FaviconController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\SocialLinkController;
use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\WhyusController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\AboutDescriptionController;
use App\Http\Controllers\Admin\AmenityController;
use App\Http\Controllers\SearchPropertiesController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ReviewsandRatingsController;
use App\Http\Controllers\Admin\FavoritesController;
use App\Http\Controllers\AddressController;
use App\Models\Offer;

Auth::routes();

Route::get('/login', function () {
    return view('auth.login'); 
})->name('login');

// Route to handle form submission
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

Route::get("/member", function () {
    return view("frontend.member");

});
Route::get("services", function () {
    return view('frontend.include.blog.php'); });
Route::get("whyuss", function () {
    return view("frontend.include.advantage.php"); });
Route::get("aboutuss", function () {
    return view("frontend.include.about.blade.php"); });
Route::get("services", function () {
    return view("frontend.include.indexbanner.php"); });
Route::get("testimonials", function () {
    return view("frontend.testimonial.blade.php"); });
Route::get("service", function () {
    return view("frontend.include.project.blade.php"); });



    Route::get('/get-postcode/{id}', [AddressController::class, 'getPostcode']);



Route::get('/hello', function () {
    return view('frontend.singleproperties');
})->name('hello');
Route::get('/', [FrontViewController::class, 'index'])->name('index');
Route::get('/properties/{categoryId?}', [FrontViewController::class, 'properties'])->name('properties');
// Route::get('/properties/search', [FrontViewController::class, 'search'])->name('frontend.search');

Auth::routes(['verify' => true]);


Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');


Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

// Route to resend the verification email
Route::post('/email/resend', [VerificationController::class, 'resend'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

    Route::get('/properties/search', [FrontViewController::class, 'search'])->name('frontend.search');


    Route::prefix('/admin')->name('admin.')->middleware(['web', 'auth', 'prevent.admin.access'])->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/dashboard', [AdminController::class, 'index'])->middleware('verified');

    // Middleware to check user role and redirect accordingly
        Route::middleware(['auth'])->group(function () {
            Route::get('/home', function () {
                if (Auth::user()->role == 3) {
                    return redirect()->route('index');
                } else {
                    return redirect()->route('admin.dashboard');
                }
            })->name('home');
        });


    // User Routes
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('index');
        Route::get('create', [UsersController::class, 'create'])->name('create');
        Route::post('store', [UsersController::class, 'store'])->name('store');
        Route::get('edit/{id}', [UsersController::class, 'edit'])->name('edit');
        Route::post('update', [UsersController::class, 'update'])->name('update');
        Route::get('delete/{id}', [UsersController::class, 'destroy'])->name('destroy');
        Route::get('deleted', [UsersController::class, 'viewDeleted'])->name('viewDeleted');
        Route::get('restore/{id}', [UsersController::class, 'restore'])->name('restore');
        Route::get('deletePermanent/{id}', [UsersController::class, 'permanentDestroy'])->name('permanentDestroy');
    });

    // Roles Routes
    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [RolesController::class, 'index'])->name('index');
        Route::get('create', [RolesController::class, 'create'])->name('create');
        Route::post('store', [RolesController::class, 'store'])->name('store');
        Route::get('edit/{id}', [RolesController::class, 'edit'])->name('edit');
        Route::post('update', [RolesController::class, 'update'])->name('update');
        Route::get('delete/{id}', [RolesController::class, 'destroy'])->name('destroy');
    });

    // Permissions Routes
    Route::prefix('permissions')->name('permissions.')->group(function () {
        Route::get('/', [PermissionsController::class, 'index'])->name('index');
        Route::get('create', [PermissionsController::class, 'create'])->name('create');
        Route::post('store', [PermissionsController::class, 'store'])->name('store');
        Route::get('edit/{id}', [PermissionsController::class, 'edit'])->name('edit');
        Route::post('update', [PermissionsController::class, 'update'])->name('update');
        Route::get('delete/{id}', [PermissionsController::class, 'destroy'])->name('destroy');
    });
        Route::resource('team', TeamController::class);
        Route::resource('faqs', FAQController::class);
        Route::resource('about_descriptions', AboutDescriptionController::class);


        // Blog Routes
        Route::resource('blogs', BlogController::class);
        Route::post('/upload-image', [BlogController::class, 'uploadImage'])->name('uploadImage');
});


   //Property, Category, Subcategories Routes

   Route::resource('admin/property', PropertyController::class);
   Route::resource('admin/categories', CategoryController::class);
   Route::resource('admin/subcategories', SubCategoryController::class);
   Route::get('/subcategories/{categoryId}', [PropertyController::class, 'getSubcategories'])->name('subcategories');

   Route::put('/admin/property/{id}/update-images', [PropertyController::class, 'updateImages'])->name('property.updateImages');

   //Testimonial Routes 
   Route::resource('admin/testimonials', TestimonialController::class);

   //MetaData Routes
   Route::resource('metadata', MetadataController::class);
   Route::put('/metadata/{id}', [MetadataController::class, 'update'])->name('metadata.update');

   //Service Routes
   Route::resource('services', ServiceController::class);


   Route::resource('favicons', FaviconController::class);

   //AboutUs Route
   Route::resource('aboutus', AboutUsController::class);

   //WhyUs Route
   Route::resource('whyus', WhyusController::class);

   //Property Route
   Route::resource('property', PropertyController::class);

   //Sitesetting route
   Route::resource('sitesettings', SiteSettingController::class);

   //Sociallinks route
   Route::resource('social-links', SocialLinkController::class);

    //Amenity route
    Route::resource('amenities', AmenityController::class);

   //Offer-Feature route
   Route::resource('offers', OfferController::class);

   // Contact routes
    Route::prefix('admin')->group(function () {
    Route::get('/contact', [App\Http\Controllers\Admin\ContactController::class, 'index'])->name('contact.index');
    Route::post('/contact/store', [App\Http\Controllers\Admin\ContactController::class, 'store'])->name('contact.store');
});

 // Review routes
 Route::prefix('admin')->group(function () {
    Route::get('/review', [ReviewsandRatingsController::class, 'index'])->name('review.index');
    Route::post('/review/store', [ReviewsandRatingsController::class, 'store'])->name('review.store');
    Route::post('/submit-review', [ReviewsandRatingsController::class, 'store'])->name('submit.review');
    Route::patch('/reviews/{review}', [ReviewsandRatingsController::class, 'update'])->name('admin.reviews.update');
});

   //Favorites Route
   Route::get('/favourite', [SingleController::class, 'render_favourite'])->name('favourite');
   
   Route::post('/favorites', [FavoritesController::class, 'store'])->name('favorites.store');
   Route::get('/admin/favorites', [FavoritesController::class, 'index'])->name('favorites.index');

  




   // Frontend Routes
   Route::view("/member", "frontend.member")->name('member');
   Route::view("/contact", "frontend.contact")->name('contact');
   Route::get('/about', [SingleController::class, 'render_about'])->name('about');
   Route::get('/contact', [SingleController::class, 'render_contact'])->name('contact');
   Route::get('/blog', [SingleController::class, 'render_blog'])->name('blog');
Route::get('/singleblogpost/{slug}', [SingleController::class, 'singlePost'])->name('singleblogpost');
   Route::get('/properties', [SingleController::class, 'render_properties'])->name('properties');
   Route::get('/propertycategories/{id}', [SingleController::class, 'properties'])->name('catProperties');
   Route::get('/singleproperties/{id}', [SingleController::class, 'render_singleProperties'])->name('singleproperties');
   Route::get('/properties/search', [SearchPropertiesController::class, 'filterProperties'])->name('frontend.searching');
   Route::get('/favourite', [SingleController::class, 'render_favourite'])->name('favourite');
   


Route::prefix('/profile')->name('profile.')->middleware(['web', 'auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\ProfilesController::class, 'index'])->name('index');
    Route::post('/update/info', [App\Http\Controllers\ProfilesController::class, 'updateInfo'])->name('update.info');
    Route::post('/update/password', [App\Http\Controllers\ProfilesController::class, 'updatePassword'])->name('update.password');
});

Route::get('/search', [SearchPropertiesController::class, 'filterProperties'])->name('frontend.searching');
Route::get('/get-subcategories/{categoryId}', [SearchPropertiesController::class, 'getSubcategories']);
Route::get('/get-suburbs-by-state/{state}', [SearchPropertiesController::class, 'getSuburbsByState'])->name('get.suburbs.by.state');


