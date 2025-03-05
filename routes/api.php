<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResponseController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/setuser', [UserController::class, 'setUser']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/events', [EventController::class, 'getEvents']);

Route::post('/addevent', [EventController::class, 'addEvent']);

Route::delete('/deleteevent', [EventController::class, 'destroyEvent']);

Route::put('/modifyevent', [EventController::class, 'modifyEvent']);

Route::get('/tickets', [TicketController::class, 'getTickets']);

Route::post('/addticket', [TicketController::class, 'addTicket']);

Route::put('/modticket', [TicketController::class, 'modifyTicket']);

Route::delete('/deleteticket', [TicketController::class, 'destroyTicket']);