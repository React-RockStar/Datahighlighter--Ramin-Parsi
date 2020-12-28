<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Support\Facades\Route;
use App\Subscription;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    if(Auth::check()) {
        $subscriptions = Subscription::where('user_id', Auth::id() )->get();
        return view('home', ['subscriptions' => $subscriptions ]);
    }
    else {
        return view('datahighlighter');
    }
})->name("datahighlighter");

Route::get('login/google', 'LoginController@redirectToProvider')->name('login.google');
Route::get('login/google/callback', 'LoginController@handleProviderCallback');
Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/plans', 'PlanController@index')->name('plans.index');
    Route::get('/plan/{plan}', 'PlanController@show')->name('plans.show');
    Route::post('/subscription', 'SubscriptionController@create')->name('subscription.create');
    Route::get('api/getTrelloBoard/{license_key}', 'SubscriptionController@getTrelloBoard');
    Route::post('edit_trello_board', 'SubscriptionController@editTrello');
});
