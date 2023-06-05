<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class Recaptcha implements Rule
{
    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        $response = Http::asForm()->post("https://www.google.com/recaptcha/api/siteverify", [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $value,
            'ip' => request()->ip(),
        ]);

        if ($response->successful() && $response->json('success') && $response->json('score') > config('services.recaptcha.min_score')) {
            return true;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function message()
    {
        return 'Failed to validate ReCaptcha.';
    }
}
