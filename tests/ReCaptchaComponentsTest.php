<?php

namespace Goedemiddag\ReCaptcha\Tests;

final class ReCaptchaComponentsTest extends TestCase
{
    public function test_it_renders_the_input_component_correctly(): void
    {
        $view = $this->blade(
            '<x-recaptcha::input :name="$name" :id="$id" />',
            ['name' => 'dominique', 'id' => 'dick']
        );

        $view->assertSee('name="dominique"', false);
        $view->assertSee('id="dick"', false);
    }

    public function test_it_renders_the_script_component_correctly(): void
    {
        config(['recaptcha.site_key' => 'a-non-valid-site-key']);

        $view = $this->blade('<x-recaptcha::script />');

        $view->assertSee('<script src="https://www.google.com/recaptcha/api.js?render=a-non-valid-site-key"></script>', false);
    }
}
