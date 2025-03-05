<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class BannerController extends Controller
{
    public function getLoginCounter($email)
    {
        $user = User::where("email", $email)->first();
        return $user ? $user->login_counter : 0;
    }

    public function setLoginCounter($email)
    {
        $user = User::where("email", $email)->first();

        if ($user) {
            $user->login_counter += 1;
            
            if ($user->login_counter > 3) {
                $user->banned = 1;
            }

            $user->save();
            return response()->json(["message" => "Login counter updated", "email" => $user->email]);
        }

        return response()->json(["error" => "User not found"], 404);
    }

    public function resetLoginCounter($email)
    {

        $user = User::where("email", $email)->first();

        if ($user) {
            $user->login_counter = 0;
            $user->save();
            return response()->json(["message" => "Bejelentkezési számláló visszaállítva", "email" => $user->email]);
        }

        return response()->json(["error" => "User not found"], 404);
    }
    public function resetByAuthorized($email)
    {

        $user = User::where("email", $email)->first();

        if ($user) {
            $user->login_counter = 0;
            $user->banned = 0;
            $user->save();
            return response()->json(["message" => "Bejelentkezési számláló visszaállítva", "email" => $user->email]);
        }

        return response()->json(["error" => "User not found"], 404);
    }

    public function banUser($email)
    {
        $user = User::where("email", $email)->first();

        if ($user) {
            $user->banned = 1;
            $user->save();
            return response()->json(["message" => "Felhasználó kitiltva, kérjük írjon emailt-t ügyfélszolgálatunknak!", "email" => $user->email]);
        }

        return response()->json(["error" => "A felhasználó nem található"], 404);
    }
}
