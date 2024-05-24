<?php

namespace Goedemiddag\ReCaptcha\Exceptions;

use Exception;

class ReCaptchaException extends Exception
{
    public static function missingSiteKey(): self
    {
        return new self('ReCaptcha site key is missing in config.');
    }

    public static function missingSecret(): self
    {
        return new self('ReCaptcha secret is missing in config.');
    }

    public static function invalidSkipIps(): self
    {
        return new self('ReCaptcha skip_ips in config should be an array.');
    }

    public static function invalidThreshold(): self
    {
        return new self('ReCaptcha threshold in config should be a float.');
    }
}
