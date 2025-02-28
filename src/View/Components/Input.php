<?php

namespace Goedemiddag\ReCaptcha\View\Components;

use Illuminate\Support\HtmlString;
use Illuminate\View\Component;

class Input extends Component
{
    public function __construct(
        public string $name = 'g-recaptcha-response',
        public ?string $id = null,
    ) {}

    public function render(): HtmlString
    {
        $id = $this->id ?? $this->name;

        return new HtmlString('<input type="hidden" id="'.$id.'" name="'.$this->name.'" />');
    }
}
