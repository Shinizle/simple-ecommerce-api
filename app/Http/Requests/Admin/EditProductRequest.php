<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EditProductRequest extends FormRequest
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
            'id' => ['required', 'exists:products,id'],
            'name' => ['required', 'max:255'],
            'price' => ['required', 'numeric', 'min:0', 'not_in:0'],
            'qty' => ['required', 'numeric', 'min:0'],
        ];
    }
}
