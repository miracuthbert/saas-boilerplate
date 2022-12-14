<?php

namespace SAAS\Http\Account\Requests\TwoFactor;

use Illuminate\Foundation\Http\FormRequest;
use SAAS\Domain\Account\Rules\DialCode;

class TwoFactorStoreRequest extends FormRequest
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
            'dial_code' => [
                'required',
                new DialCode()
            ],
            'phone_number' => 'required',
        ];
    }
}
