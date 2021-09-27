<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required', 'min:3'
            ],
            'email' => [
                'required', 'email', 'unique:user'
                //'required', 'email', Rule::unique('users')->ignore($user->id)
                // 'required', 'email', Rule::unique((new User)->getTable())->ignore($this->route()->user->id ?? null)
            ],
            'password' => [
                $this->route()->user ? 'nullable' : 'required', 'confirmed', 'min:6'
            ],
            'last_name' => [
                'required'
            ],
            'id_type_identification' => [
                'required'
            ],
            'number_identification' => [
                'required'
            ],
            'id_rol' => [
                'required'
            ],
            'email' => [
                'required'
            ],
            'password_confirmation' => [
                'required'
            ],

        ];
    }

    public function messages()
    {
        return [
            'name.required'      => 'El nombre es requerido.',
            'last_name.required'      => 'El apellido es requerido.',
            'id_type_identification.required'      => 'El tipo de identificación es requerido.',
            'number_identification.required'      => 'El número de identificacion es requerido.',
            'id_rol.required'      => 'El rol es requerido.',
            'email.required'      => 'El correo electrónico es requerido.',
            'password.required'      => 'La contraseña es requerida.',
            'password_confirmation.required'      => 'La contraseña es requerida.',
        ];
    }
}
