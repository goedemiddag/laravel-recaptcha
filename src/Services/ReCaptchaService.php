<?php

namespace Goedemiddag\ReCaptcha\Services;

use Goedemiddag\ReCaptcha\Data\ReCaptchaAttempt;
use ReCaptcha\ReCaptcha;
use ReCaptcha\Response;
use Symfony\Component\HttpFoundation\IpUtils;

class ReCaptchaService
{
    public function __construct(
        private readonly ReCaptcha $recaptcha,
    ) {
    }

    public function getRecaptchaResponse(ReCaptchaAttempt $attempt): Response
    {
        if ($attempt->hasAction()) {
            $this->recaptcha->setExpectedAction($attempt->action);
        }

        return $this->recaptcha
            ->setScoreThreshold(config('recaptcha.threshold'))
            ->verify($attempt->response, $attempt->remoteIp);
    }

    public function verify(ReCaptchaAttempt $attempt): bool
    {
        if ($attempt->hasRemoteIp() && IpUtils::checkIp($attempt->remoteIp, config('recaptcha.skip_ips'))) {
            return true;
        }

        $response = $this->getRecaptchaResponse($attempt);

        if (! $response->isSuccess()) {
            return false;
        }

        return $response->getScore() >= config('recaptcha.threshold');
    }
}
