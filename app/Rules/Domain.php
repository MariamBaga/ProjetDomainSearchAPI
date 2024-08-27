<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Domain implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Regex pour valider un nom de domaine (sld.tld)
        $pattern = '/^(?!:\/\/)([a-zA-Z0-9-]{1,63}\.)+[a-zA-Z]{2,6}$/';

        // Vérifie si le domaine correspond au pattern
        return preg_match($pattern, $value) === 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Le nom de domaine n\'est pas valide.';
    }
}
