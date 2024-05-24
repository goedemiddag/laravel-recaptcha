<?php

namespace Goedemiddag\ReCaptcha;

use Goedemiddag\ReCaptcha\Exceptions\ReCaptchaException;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use ReCaptcha\ReCaptcha;

class ReCaptchaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ReCaptcha::class, function () {
            $secret = config('recaptcha.secret_key');
            if ($secret === null) {
                throw ReCaptchaException::missingSecret();
            }

            if (! is_array(config('recaptcha.skip_ips'))) {
                throw ReCaptchaException::invalidSkipIps();
            }

            if (! is_numeric(config('recaptcha.threshold')) || config('recaptcha.threshold') < 0 || config('recaptcha.threshold') > 1) {
                throw ReCaptchaException::invalidThreshold();
            }

            return new ReCaptcha(config('recaptcha.secret_key'));
        });
    }

    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../lang/', 'recaptcha');

        $this->publishes([__DIR__.'/../config/recaptcha.php' => config_path('recaptcha.php')],
            'recaptcha-config'
        );

        $this->publishes([
            __DIR__.'/../lang/' => base_path('lang/vendor/recaptcha')],
            'recaptcha-lang'
        );

        $this->mergeConfigFrom(__DIR__.'/../config/recaptcha.php', 'recaptcha');

        Blade::componentNamespace('Goedemiddag\\ReCaptcha\\View\\Components', 'recaptcha');
    }
}
