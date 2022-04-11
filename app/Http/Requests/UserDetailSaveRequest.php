<?php

namespace App\Http\Requests;

use App\Rules\PhoneNumberRule;
use Illuminate\Foundation\Http\FormRequest;

class UserDetailSaveRequest extends FormRequest
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
        $rules = [
            'name' => 'required|min:3|max:50',
            'surname' => 'required|min:3|max:50',
            'nickname' => 'nullable|string|max:100',
            'phone' => 'nullable|max:20|string'
        ];
        if (!is_null(request()->get('password'))){
            $rules['password'] = 'required|min:8|confirmed';
        }

        return $rules;
    }
}
