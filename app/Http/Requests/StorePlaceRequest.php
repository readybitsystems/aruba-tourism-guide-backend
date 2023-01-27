<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlaceRequest extends FormRequest
{
    public function rules()
    {
        return [
            'tour_id'       => 'required|exists:tours,id|integer',
            'title'         => 'required|max:255',
            'sub_title'     => 'required|max:255',
            'audio'         => 'required',
            'description'   => 'nullable'
        ];
    }
}
