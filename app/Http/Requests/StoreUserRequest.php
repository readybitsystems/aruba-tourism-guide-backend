<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_name'        => 'required|max:255',
            'email'            => 'required|max:255|email|unique:users,email',
            'phone'            => 'required|digits_between:4,20|numeric',
            'password'         => 'required|min:6|max:15',
            'confirm_password' => 'required|min:6|same:password'
        ];
    }
}
