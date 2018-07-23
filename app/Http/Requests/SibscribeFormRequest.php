<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SibscribeFormRequest extends FormRequest
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
            'number'    =>  'required|numeric|min:4111111111111111|max:9999999999999999',
            'cvc'       =>  'required|numeric|min:000|max:999',
            'exp_month' =>  'required|numeric|min:01|max:12',
            'exp_year'  =>  'required|numeric|min:00|max:99',
        ];
    }
}
