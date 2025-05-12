<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    public function authorize(): bool
    {
        return true; // Разрешаем авторизованным пользователям
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // dd($this->all());
        return [
            // 'user_id' => 'required|exists:user,id',
            'title' => 'required|string|min:1|max:300',
            'content' => 'required|string|min:1',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'Необходимо указать пользователя',
            'user_id.exists' => 'Выбранный пользователь не существует',
            'price.required' => 'Необходимо указать цену',
            'title.min' => 'Заголовок не может быть пустым',
            'content.min' => 'Контент не может быть пустым',
        ];
    }
}
