<?php

namespace Goedemiddag\ReCaptcha\Rules;

use Closure;
use Goedemiddag\ReCaptcha\Data\ReCaptchaAttempt;
use Goedemiddag\ReCaptcha\Services\ReCaptchaService;
use Illuminate\Contracts\Validation\ValidationRule;

class ReCaptchaRule implements ValidationRule
{
    public function __construct(
        public ?string $action = null,
    ) {}

    public function passes(string $attribute, mixed $value): bool
    {
        $service = app(ReCaptchaService::class);

        $attempt = new ReCaptchaAttempt(
            response: $value,
            remoteIp: request()->ip(),
            action: $this->action,
        );

        return $service->verify($attempt);
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $this->passes($attribute, $value)) {
            $fail($this->message());
        }
    }

    public function message(): string
    {
        return __('recaptcha::recaptcha.validation.failed');
    }
}
