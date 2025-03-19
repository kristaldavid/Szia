<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ResponseController;




class AuthController extends ResponseController
{

    public function register( UserRegisterRequest $request ) {

        $request->validated();

        $user = User::create([

            "name" => $request["name"],
            "email" => $request["email"],
            "password" => bcrypt( $request["password"]),
            "role" => 0
        ]);

        return $this->sendResponse( $user->name, "Sikeres regisztráció");
    }

    public function login(UserLoginRequest $request)
    {
        $request->validated();

        $bannerController = new BannerController();
        $user = User::where("email", $request["email"])->first();

       
        if (!$user) {
            return $this->sendError("Hiba", "Felhasználó nem található", 404);
        }

       
        if ($user->banned) {
            return $this->sendError("Hiba", "Felhasználó ki van tiltva", 403);
        }

       
        $loginCounter = $bannerController->getLoginCounter($request["email"]);

       
        if ($loginCounter >= 3) {
            $bannerController->banUser($request["email"]);
            return $this->sendError("Hiba", "Túl sok próbálkozás - felhasználó kitiltva", 403);
        }

        if (Auth::attempt(["email" => $request["email"], "password" => $request["password"]])) {
            $authUser = Auth::user();
            $token = $authUser->createToken($authUser->email . "Token")->plainTextToken;

            $bannerController->resetLoginCounter($request["email"]);

            $data = [
                "user" => ["user" => $authUser->email],
                "token" => $token
            ];

            return $this->sendResponse($data, "Sikeres bejelentkezés");
        }
         
         $bannerController->setLoginCounter($request["email"]);

         return $this->sendError("Hiba", "Helytelen felhasználónév vagy jelszó", 401);
     }
 

    public function logout() {

        auth( "sanctum" )->user()->currentAccessToken()->delete();
        $name = auth( "sanctum" )->user()->name;

        return $this->sendResponse( $name, "Sikeres kijelentkezés");
    }
    









}
