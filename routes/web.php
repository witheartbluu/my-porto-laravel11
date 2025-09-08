<?php

// portfolio frontend fallback or Blade demo pages
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
//ini routing dasar
// Route::get('/blog', function() {
//     return view('blog');
// });

//routing pake params
// Route::get('/blog/{id}', function($id){
//     return 'this is blog detail:'.$id;
// });

//ini buat dari tutorial

// Route::view('/blog', 'blog');
