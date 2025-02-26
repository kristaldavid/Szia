<?php

namespace App\Http\Controllers;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\ResponseController;
use Illuminate\Support\Facades\Gate;

class UserController extends ResponseController {

    
    public function setUser(Request $request) {

        if ( !Gate::allows("organizer") ) {
            return $this->sendError("Autentikációs hiba", "Nincs jogosultsága", 401);
        }

        $user = User::find($request["id"]);
        $user->user = 0;
        $user->worker = 1;
        $user->organizer = 2;

        $user->update();

        return $this->sendResponse($user->name, "Felhasználói jogosultságok módosítva");
    }

}
