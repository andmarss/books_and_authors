<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends StoreUserRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return $this->user() !== null;
    }
}
