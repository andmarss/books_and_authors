<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
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
            'pseudonym' => 'required|exists:users,pseudonym|alpha_dash',
            'password' => 'required|min:6',
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'pseudonym.required'   => 'Псевдоним обязателен для заполнения',
            'pseudonym.exists'     => 'Пользователь с таким псевдонимом не найден',
            'pseudonym.alpha_dash' => 'Псевдоним может содержать только буквы, цифры, дефис и подчеркивание',
            'password.required'    => 'Пароль обязателен для заполнения',
            'password.min'         => 'Пароль должен быть не менее 6 символов',
        ];
    }
}
