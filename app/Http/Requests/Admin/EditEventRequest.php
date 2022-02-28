<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EditEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['required', 'exists:events,id'],
            'name' => ['required', 'max:255'],
            'description' => ['required'],
            'start_periode' => ['required', 'date_format:Y-m-d H:i:s'],
            'end_periode' => ['required', 'date_format:Y-m-d H:i:s']
        ];
    }
}
