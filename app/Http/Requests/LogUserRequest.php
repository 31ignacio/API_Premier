<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class LogUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            //
                'email' =>'required|email|exists:users,email',//verifie si l'email existe vraiment dans la table 'users' colum 'email'
                'password' =>'required'

        ];
    }

    public function failedValidation(Validator $validator){

        throw new HttpResponseException(response()->json([
            'success'=>false,
            'status_code'=>422,
            'message'=>'Erreur de validation',
            'errorsList'=>$validator->errors()
        ]));
    }

    public function messages(){

        return [
            'email.required'=>'Veuillez entrer un adresse mail',
            'email.email'=>'Adresse email non valide',
            'email.exists'=>'Cette adresse mail n\'existe pas',
            'password.exists'=>'Ce mot de passe n\'existe pas',

            'password.required'=>'Veuillez entrer un mot de passe '


        ];
    }
}
