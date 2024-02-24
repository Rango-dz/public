<?php

namespace App\Rules;

use App\Models\WhiteListedDomain;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IsValidDomain implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $host = parse_url($value)['host'] ?? null;
        $isExist = WhiteListedDomain::where('name', $host)->exists();

        if (!$isExist) {
            $fail('The Domain is not white listed in our records');
        }
    }
}
