<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // pembatasan siapa saja yg boleh isi add users
        // ubah ke true agar lolos validasi
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
            //validasi add users
            'name' => 'required|string|max:80',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'phone' => 'string',
            'address' => 'string',
            'roles' => 'string',
        ];
    }


}
