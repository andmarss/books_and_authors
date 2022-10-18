<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
        return $this->user() !== null;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'title'       => 'required',
            'description' => 'nullable',
            'text'        => 'nullable',
            'image'       => 'nullable|image',
            'status'      => sprintf('required|in:%s,%s,%s',
                \App\Models\Book::STATUS_IN_PROGRESS,
                \App\Models\Book::STATUS_FINISHED,
                \App\Models\Book::STATUS_CANCELLED
            ),
            'category_id' => 'required|exists:book_categories,id',
            'author_id'   => 'required|exists:users,id'
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'title.required'       => 'Название обязательно для заполнения',
            'status.required'      => 'Статус обязателен для заполнения',
            'category_id.required' => 'Категория обязательна для заполнения',
            'author_id.required'   => 'Автор обязателен для заполнения',
            'category_id.exists'   => 'Категория не найдена',
            'author_id.exists'     => 'Автор не найден',
            'status.in'            => 'Неверный статус',
            'image.image'          => 'Неверный формат изображения'
        ];
    }
}
