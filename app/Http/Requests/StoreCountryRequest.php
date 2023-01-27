<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCountryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'image' => 'required|image|mimes:jpg,png,jpeg'
        ];
    }
}
