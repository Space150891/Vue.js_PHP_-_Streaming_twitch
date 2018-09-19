<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LiqpayFormRequest extends FormRequest
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
            'subscription_plan_id'    =>  'required|integer|between:1,3',
            'month_plan_id'       =>  'required|integer|between:1,4',
            'amount' =>  'required|between:0,999.99'
        ];
    }
}
