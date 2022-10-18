<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * @var bool
     */
    protected $stopOnFirstFailure = true;

    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'nullable',
            'pseudonym' => 'required|unique:users,pseudonym|alpha_dash',
            'password' => 'required|confirmed|min:8',
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'first_name.required'  => 'Имя обязательно для заполнения',
            'last_name.required'   => 'Фамилия обязательна для заполнения',
            'pseudonym.required'   => 'Псевдоним обязателен для заполнения',
            'pseudonym.unique'     => 'Псевдоним должен быть уникальным',
            'pseudonym.alpha_dash' => 'Псевдоним может содержать только буквы, цифры, дефис и подчеркивание',
            'password.required'    => 'Пароль обязателен для заполнения',
            'password.confirmed'   => 'Пароли не совпадают',
            'password.min'         => 'Пароль должен быть не менее 8 символов',
        ];
    }
}
