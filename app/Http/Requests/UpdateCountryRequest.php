<?php

namespace App\Http\Requests;

class UpdateCountryRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpg,png,jpeg'
        ];
    }
}
