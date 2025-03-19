<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\ResponseController;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\UserModRequest;
use App\Http\Resources\UserResource;

class UserController extends ResponseController {

    public function setUser(UserModRequest $request) {
        if (!Gate::allows("organizer")) {
            return $this->sendError("Autentikációs hiba", "Nincs jogosultsága", 401);
        }

        $user = User::find($request["id"]);

        if (!$user) {
            return $this->sendError("Hiba", "Felhasználó nem található", 404);
        }

        $user->role = $request["role"];
        $user->save(); 

        return $this->sendResponse($user->name, "Felhasználói jogosultságok módosítva");
    }
    public function getUser(Request $request) {
        if (!Gate::allows("organizer")) {
            return $this->sendError("Autentikációs hiba", "Nincs jogosultsága", 401);
        }

        $users = User::all();
        return $this->sendResponse(UserResource::collection($users), "Felhasználók sikeresen lekérve");
    }

    public function getUserByEmail(Request $request) {
        if (!Gate::allows("organizer")) {
            return $this->sendError("Autentikációs hiba", "Nincs jogosultsága", 401);
        }
        $user = User::where("email", $request["email"])->first();
        return $this->sendResponse(new UserResource($user), "Felhasználó sikeresen lekérve");
    }
}
