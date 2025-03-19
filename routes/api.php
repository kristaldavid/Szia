<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\BannerController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [UserController::class, 'getUser']);
    Route::post('/setuser', [UserController::class, 'setUser']);
    Route::post('/addevent', [EventController::class, 'addEvent']);

    
    Route::delete('/deleteevent', [EventController::class, 'destroyEvent']);
    Route::put('/modifyevent', [EventController::class, 'modifyEvent']);

    Route::put('/modticket', [TicketController::class, 'modifyTicket']);
    
    Route::delete('/deleteticket', [TicketController::class, 'destroyTicket']);
    Route::get('/tickets', [TicketController::class, 'getTickets']);
    Route::post('/addticket', [TicketController::class, 'addTicket']);

    Route::get('/userbyemail', [UserController::class, 'getUserByEmail']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/events', [EventController::class, 'getEvents']);
Route::get('/event', [EventController::class, 'getEvent']);




