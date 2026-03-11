<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DomObjectController;

Route::get('/', fn() => redirect()->route('dom-objects.index'));
Route::get('/dom-objects', [DomObjectController::class, 'index'])->name('dom-objects.index');