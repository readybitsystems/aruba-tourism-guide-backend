<?php

namespace App\Http\Requests;


class UpdatePlaceRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'title'       => 'required|max:255',
            'sub_title'   => 'nullable|max:255',
            'description' => 'nullable'
        ];
    }
}
