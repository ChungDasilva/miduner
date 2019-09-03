<?php
use App\Main\Route;

Route::get('/', [App\Controllers\HomeController::class, 'home'])->name('home');

Route::get('/about', [App\Controllers\HomeController::class, 'about'])->name('about');

Route::get('/post', [App\Controllers\HomeController::class, 'post'])->middleware('auth');

Route::get('/contact', [App\Controllers\HomeController::class, 'contact']);

Route::resource('users', 'UserController')->except(['create', 'edit']);
Route::resources([
    'posts' => 'PostController',
    'partners' => 'PartnerController',
])->except(['create', 'edit'])->middleware('auth');

Route::get('/add-to-cart/{id}', 'CartController@addToCart');
Route::get('/get-cart', 'CartController@getCart');
Route::get('/remove-cart/{id}', 'CartController@removeCart');
