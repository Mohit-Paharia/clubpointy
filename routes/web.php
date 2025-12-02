<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SearchController;

use App\Models\Club;
use App\Models\User;
use App\Models\Event;
use App\Models\Chat;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

Route::model('club', Club::class);
Route::model('event',Event::class);
Route::model('user', User::class);
Route::model('chat', Chat::class);
Route::model('country', Country::class);
Route::model('state', State::class);
Route::model('city', City::class);

Route::get('/', function (Request $request) {

    $ip = $request->ip(); 
    // $response = Http::get("http://ipinfo.io/{$ip}/json")->json(); 
    $response = Http::get("http://ipinfo.io/106.76.94.122/json")->json(); 

    return view('welcome', [
        'location' => Location::firstOrCreate([
            'city' => $response['city'],
            'state' => $response['region'],
            'country' => $response['country'],
        ])
    ]);
});

Route::name('admin.')
    ->prefix('admin')
    ->middleware( ['auth', 'admin'])
    ->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::post('/approve/{club}', [AdminController::class,'approveClub'])->name('club.approve');
    Route::post('/reject/{club}', [AdminController::class,'rejectClub'])->name('club.reject');
});

Route::prefix('auth')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
    
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/register', [RegistrationController::class, 'show'])->name('register.show');
    Route::post('/register', [RegistrationController::class, 'register'])->name('register.perform');
    Route::get('/register/verify', [RegistrationController::class, 'verify'])->name('email.verification.url');
});

Route::name('club.')
    ->prefix('clubs/{club}')
    ->middleware('auth')
    ->controller(ClubController::class)
    ->group(function () {

        Route::middleware('club')->group(function () {
            Route::get('/dashboard', 'dashboard')->name('dashboard');

            Route::post('/join/accept/{user}', 'acceptJoinRequest')->name('join.accept');
            Route::post('/join/reject/{user}', 'rejectJoinRequest')->name('join.reject');

            Route::post('/block/{user}', 'blockUser')->name('user.block');
            Route::post('/unblock/{user}', 'unblockUser')->name('user.unblock');

            Route::delete('/members/{user}', 'removeMember')->name('member.remove');

            Route::post('/events', 'storeEvent')->name('event.store');
            Route::get('/events/create', 'createEvent')->name('event.create');
            Route::get('/events/{event}', 'showEvent')->name('event.show');
            Route::put('/events/{event}', 'updateEvent')->name('event.update');
            Route::delete('/events/{event}', 'deleteEvent')->name('event.delete');

            Route::put('/setting', 'updateSetting')->name('setting.update');
        });

        Route::post('/chats', 'storeChat')->name('chat.store');
        Route::delete('/chats/{chat}', 'deleteChat')->name('chat.delete');
});

Route::middleware('auth')->controller(ProfileController::class)->group(function () {
    Route::get('/profile', 'index')->name('profile');
});


Route::name('api.')->prefix('api/')->group(function () {
    Route::get('search/clubs', [SearchController::class, 'clubs'])->name('search.clubs');
    Route::get('search/users', [SearchController::class, 'users'])->name('search.users');
    Route::get('search/events', [SearchController::class, 'events'])->name('search.events');

    Route::get('locations/countries', [LocationController::class, 'countries'])->name('countries');
    Route::get('location/countries/{country}/states', [LocationController::class, 'states'])->name('countries.states');
    Route::get('location/countries/{country}/states/{state}/cities',[LocationController::class, 'cities'])->name('countries.states.cities');
});