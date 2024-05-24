<?php

namespace Goedemiddag\ReCaptcha\View\Components;

use Goedemiddag\ReCaptcha\Exceptions\ReCaptchaException;
use Illuminate\Support\HtmlString;
use Illuminate\View\Component;

class Script extends Component
{
    /**
     * @throws ReCaptchaException
     */
    public function render(): HtmlString
    {
        $siteKey = config('recaptcha.site_key');

        if (! $siteKey) {
            throw ReCaptchaException::missingSiteKey();
        }

        return new HtmlString('
            <script src="https://www.google.com/recaptcha/api.js?render='.$siteKey.'"></script>
            <script>
                window.reCaptcha = {
                    render: function(action, callback) {
                        grecaptcha.execute("'.$siteKey.'", {action: action}).then(callback);
                    }
                }
            </script>
        ');
    }
}
