<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'cart_ids' => ['required', 'array'],
            'cart_ids.*' => ['exists:carts,id'],
            'customer_delivery_name' => ['required'],
            'customer_delivery_address' => ['required'],
            'customer_delivery_phone' => ['required'],
            'delivery_fee' => ['required', 'numeric'],
            'discount' => ['numeric', 'nullable'],
            'note' => ['nullable'],
        ];
    }
}
