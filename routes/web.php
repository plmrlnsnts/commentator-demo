<?php

use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use JD\Cloudder\Facades\Cloudder;

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
    Auth::login(User::find(rand(1, 50)));

    return view('home', ['commentable' => Post::first()]);
});

Route::post('/upload', function (Request $request) {
    $request->validate(['file' => ['required', 'image']]);

    Cloudder::upload($request->file('file')->getRealPath(), null);

    return response()->json([
        'path' => Cloudder::getResult(Cloudder::getPublicId())['secure_url']
    ]);
});
