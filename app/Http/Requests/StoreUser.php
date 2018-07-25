<?php

namespace App\Http\Requests;

use App\Rules\UserRole;
use App\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->role_id <= User::ROLE_ADMIN;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255' . ( $this->method() == 'POST' ? '|unique:users' : '' ),
            'password' => 'string|min:6|confirmed|' . ( $this->method() == 'PUT' ? 'nullable' : 'required' ),
            'role_id' => new UserRole
        ];
    }
}
