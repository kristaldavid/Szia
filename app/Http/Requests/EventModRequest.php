<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class EventModRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'location' => 'required|string',
            'start_date' => 'required',
            'end_date' => 'required'
        ];
    }

    public function messages() {
        return [
            'name.required' => 'A név elvárt',
            'description.required' => 'A leírás elvárt',
            'location.required' => 'A helyszín elvárt',
            'start_date.required' => 'Kezdő időpont elvárt',
            'end_date.required' => 'Záró időpont elvárt'
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
