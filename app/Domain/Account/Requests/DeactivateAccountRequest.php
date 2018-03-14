<?php

namespace SAASBoilerplate\Domain\Account\Requests;

use Illuminate\Foundation\Http\FormRequest;
use SAASBoilerplate\Domain\Auth\Rules\CurrentPassword;

class DeactivateAccountRequest extends FormRequest
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
            'current_password' => [
                'required',
                new CurrentPassword()
            ]
        ];
    }
}
