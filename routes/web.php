<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MainController;
use App\Http\Controllers\EventController;

Route::get('/', [MainController::class, 'main']);

Route::get('/events/findAll', [EventController::class, 'findAll']);

Route::get('/events/findOne/{id}', [EventController::class, 'findOne']);

Route::get('/events/findAlway', [EventController::class, 'findAlway']);

Route::post('/events/create', [EventController::class, 'createEvent']);

Route::fallback(function () {
    return redirect('/api/documentation');
});

?>