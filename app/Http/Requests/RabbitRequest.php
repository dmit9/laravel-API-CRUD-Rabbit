<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RabbitRequest extends FormRequest
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
            'name' => ['required', 'string' ,'min:2','max:60', 'regex:/^[a-zA-Z0-9]+$/'],
            'email' => ['required', 'email'],
            'text' => ['required', 'string','min:2','max:300'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,gif',  'max:2048'],
        ];
    }
}
