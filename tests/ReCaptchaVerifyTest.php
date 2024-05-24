<?php

namespace Goedemiddag\ReCaptcha\Tests;

use Goedemiddag\ReCaptcha\Data\ReCaptchaAttempt;
use Goedemiddag\ReCaptcha\Rules\ReCaptchaRule;
use Goedemiddag\ReCaptcha\Services\ReCaptchaService;
use PHPUnit\Framework\Attributes\Before;

class ReCaptchaVerifyTest extends TestCase
{
    #[Before]
    public function setup(): void
    {
        parent::setUp();

        config(['recaptcha.site_key' => 'a-non-valid-site-key']);
        config(['recaptcha.secret_key' => 'a-non-valid-secret-key']);
    }

    public function test_the_validation_rule_fails_with_the_wrong_token(): void
    {
        $this->mockGoogleReCaptcha(false);

        $service = app(ReCaptchaService::class);

        $attempt = new ReCaptchaAttempt(
            response: 'wrong-token',
            action: 'submit',
        );

        $this->assertFalse($service->verify($attempt));
    }

    public function test_it_will_pass_with_valid_token(): void
    {
        $this->mockGoogleReCaptcha();

        $service = app(ReCaptchaService::class);

        $attempt = new ReCaptchaAttempt(
            response: 'valid-token',
            action: 'submit',
        );

        $this->assertTrue($service->verify($attempt));
    }

    public function test_it_will_pass_validations_with_ip_in_skip_ips(): void
    {
        config(['recaptcha.skip_ips' => ['127.0.0.1']]);

        $this->mockGoogleReCaptcha(false);

        $service = app(ReCaptchaService::class);

        $attempt = new ReCaptchaAttempt(
            response: 'valid-token',
            remoteIp: '127.0.0.1',
            action: 'submit',
        );

        $this->assertTrue($service->verify($attempt));
    }

    public function test_the_validation_rule_fails_with_wrong_token(): void
    {
        $this->mockGoogleReCaptcha(false);

        $rule = new ReCaptchaRule();

        $passed = true;
        $fail = function () use (&$passed) {
            $passed = false;
        };

        $rule->validate('g-recaptcha-response', 'wrong-token', $fail);

        $this->assertFalse($passed);
    }

    public function test_the_validation_rule_passes_with_correct_token(): void
    {
        $this->mockGoogleReCaptcha();

        $rule = new ReCaptchaRule();

        $passed = true;
        $fail = function () use (&$passed) {
            $passed = false;
        };

        $rule->validate('g-recaptcha-response', 'correct-token', $fail);

        $this->assertTrue($passed);
    }
}
