<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('/', [Controllers\ShortLink::class, 'index'])->name('index');
Route::get('/get-last-shorts', [Controllers\ShortLink::class, 'getLinks'])->name('get.last.shorts');
Route::post('/make-short-link', [Controllers\ShortLink::class, 'makeShortLink'])->name('make.short.link');
