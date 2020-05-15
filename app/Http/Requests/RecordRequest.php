<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecordRequest extends FormRequest
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
            'date'     => 'required|date_format:Y-m-d',
            'distance' => 'required|numeric|between:0.1,99',
        ];
    }
    
    public function attributes()
    {
        return [
            'date'     => '記録日',
            'distance' => '走行距離',
        ];
    }
}
