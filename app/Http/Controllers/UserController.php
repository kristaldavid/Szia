<?php

namespace App\Http\Controllers;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\ResponseController;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\UserModRequest;

class UserController extends ResponseController {

    
    public function setUser(UserModRequest $request) {

        if ( !Gate::allows("organizer") ) {
            return $this->sendError("Autentikációs hiba", "Nincs jogosultsága", 401);
        }

        $user = User::find($request["id"]);
        $user->role = $request["role"];
        

        $user->update();

        return $this->sendResponse($user->name, "Felhasználói jogosultságok módosítva");
    }

}
