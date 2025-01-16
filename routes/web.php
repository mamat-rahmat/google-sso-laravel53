<?php

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome', ['users' => User::all()]);
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
});

// Handle Google callback
Route::get('/auth/google/callback', function () {
    try {
        $googleUser = Socialite::driver('google')->user();

        // Find or create a user
        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'password' => bcrypt(str_random(16)), // Random password, it won't be used
            ]
        );

        // Log in the user
        Auth::login($user);

        // Redirect to the home page
        return redirect('/'); // Redirect to a page of your choice
    } catch (Exception $e) {
        return redirect('/login')->with('error', 'Google authentication failed.');
    }
});
