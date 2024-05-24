<?php

namespace Goedemiddag\ReCaptcha\Tests;

use Goedemiddag\ReCaptcha\Exceptions\ReCaptchaException;
use Goedemiddag\ReCaptcha\Services\ReCaptchaService;
use Illuminate\View\ViewException;

final class ReCaptchaTest extends TestCase
{
    public function test_it_throws_an_error_without_site_key(): void
    {
        $this->withoutExceptionHandling();

        $this->expectException(ViewException::class);

        config(['recaptcha.site_key' => null]);

        $this->blade('<x-recaptcha::script />');

        $this->expectException(ReCaptchaException::class);
    }

    public function test_it_throws_an_error_without_secret_key(): void
    {
        $this->expectException(ReCaptchaException::class);

        config(['recaptcha.site_key' => 'a-non-valid-site-key']);
        config(['recaptcha.secret_key' => null]);

        app(ReCaptchaService::class);
    }

    public function test_it_throws_an_error_with_invalid_skip_ips(): void
    {
        $this->expectException(ReCaptchaException::class);

        config(['recaptcha.site_key' => 'a-non-valid-site-key']);
        config(['recaptcha.secret_key' => 'a-non-valid-secret-key']);
        config(['recaptcha.skip_ips' => '127.0.0.1']);

        app(ReCaptchaService::class);
    }

    public function test_it_throws_an_error_with_invalid_thresholds(): void
    {
        $this->expectException(ReCaptchaException::class);

        config(['recaptcha.site_key' => 'a-non-valid-site-key']);
        config(['recaptcha.secret_key' => 'a-non-valid-secret-key']);
        config(['recaptcha.threshold' => 'abc']);

        app(ReCaptchaService::class);
    }
}
