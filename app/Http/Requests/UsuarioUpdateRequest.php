<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'        => 'required|exists:usuarios,id',
            'documento' => 'required|numeric|min:1000',
            'nombres'   => 'required|min:4',
            'apellidos' => 'required|min:4',
            'correo'    => 'required|email',
            'telefono'  => 'required|numeric',
        ];
    }
}
