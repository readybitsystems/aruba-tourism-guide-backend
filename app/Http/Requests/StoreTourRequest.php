<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTourRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title'        => 'required|max:255',
            'country_id'   => 'required|numeric',
            'image'        => 'required',
            'duration'     => 'required'
        ];
    }
}
