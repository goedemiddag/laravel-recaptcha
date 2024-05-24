<?php

namespace Goedemiddag\ReCaptcha\Data;

class ReCaptchaAttempt
{
    public function __construct(
        public string $response,
        public ?string $remoteIp = null,
        public ?string $action = null,
    ) {
    }

    public function hasAction(): bool
    {
        return $this->action !== null;
    }

    public function hasRemoteIp(): bool
    {
        return $this->remoteIp !== null;
    }
}
