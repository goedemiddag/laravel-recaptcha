<?php

namespace Goedemiddag\ReCaptcha\Tests;

use Goedemiddag\ReCaptcha\ReCaptchaServiceProvider;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Mockery;
use Mockery\MockInterface;
use ReCaptcha\ReCaptcha;
use ReCaptcha\Response;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use InteractsWithViews;

    protected function getPackageProviders($app): array
    {
        return [
            ReCaptchaServiceProvider::class,
        ];
    }

    protected function mockGoogleReCaptcha(bool $isSuccessful = true, float $score = 0.9): MockInterface
    {
        return $this->mock(ReCaptcha::class, function ($mock) use ($isSuccessful, $score) {
            $mock->shouldReceive('verify')
                ->andReturn(new Response(success: $isSuccessful, score: $score));

            $mock->shouldReceive('setScoreThreshold')
                ->withArgs([Mockery::any()])
                ->andReturnSelf();

            $mock->shouldReceive('setExpectedAction')
                ->andReturnSelf();
        });
    }
}
