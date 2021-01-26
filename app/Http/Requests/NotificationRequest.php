<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
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
            'positionSelectBox' => 'required|not_in:0',
            //'subject' => 'required'
        ];
    }
    /**
     * messages for the validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'positionSelectBox.not_in' => 'please select position',
            //'subject.required' => 'subject is a required field'
        ];
    }
}
