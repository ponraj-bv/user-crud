<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'doj' => ['required', 'date'],
            'doq' => ['nullable', 'date', 'after:doj'],
            'photo' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'doj.required' => "Date of joining is required",
            'doq.after' => "Date of leaving should be after date of joining"
        ];
    }
}
