<?php

use App\Http\Controllers\ChatQamhaController;
use Illuminate\Support\Facades\Route;

Route::post('/chat-qamha', [ChatQamhaController::class, 'chat'])->middleware('throttle:30,1')->name('chat-qamha');
