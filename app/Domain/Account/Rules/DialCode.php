<?php

namespace SAASBoilerplate\Domain\Account\Rules;

use Illuminate\Contracts\Validation\Rule;
use PragmaRX\Countries\Package\Countries;

class DialCode implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !(Countries::where('callingCode.0', $value)->first()->isEmpty());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The dial code is invalid.';
    }
}
