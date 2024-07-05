<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkSessionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'status' => 'required|string',
            'breaks.*.start_time' => 'required|date',
            'breaks.*.end_time' => 'required|date'
        ];
    }
}