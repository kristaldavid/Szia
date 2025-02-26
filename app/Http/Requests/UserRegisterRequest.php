<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'organizer' => 'nullable|integer|in:0,1',
            'worker' => 'nullable|integer|in:0,1',
        ];
    }
    public function messages() {

        return [
            "name.required" => "Név nem lehet üres",
            "name.max" => "Túl hosszú név",
            "name.unique" => "Létező név",
            "email.required" => "Email nem lehet üres",
            "email.unique" => "Létező email",
            "password.required" => "Jelszó nem lehet üres",
            "password.min" => "Túl rövid jelszó",
            "password.regex" => "A jelszzónak tartalmazia kell kisbetűt, nagybetűt és számot",
            "confirm_password.same" => "Nem egyező jelszó"
        ];
    }

    public function failedValidation( Validator $validator ) {

        throw new HttpResponseException( response()->json([

            "success" => false,
            "message" => "Beviteli hiba",
            "data" => $validator->errors()
        ]));
    }
}
