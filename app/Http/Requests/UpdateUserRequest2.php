<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest2 extends FormRequest
{
    public function rules()
    {
        return [
            'user_name'        => 'required|max:255',
            'phone'            => 'required',
            'password'         => 'nullable|min:6|max:100',
            'confirm_password' => 'nullable|min:6|same:password'
        ];
    }
}