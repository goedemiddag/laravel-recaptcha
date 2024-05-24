# Laravel ReCAPTCHA

This is a Laravel package for Google reCAPTCHA v3.

## Installation

You can install the package via composer:

```bash
composer require goedemiddag/laravel-recaptcha
```

Add the following environment variables to your `.env` file:

```bash
RECAPTCHA_SITE_KEY=YOUR_SITE_KEY
RECAPTCHA_SECRET_KEY=YOUR_SECRET_KEY
RECAPTCHA_THRESHOLD=0.3
```

You can optionally publish the config file:

```bash
php artisan vendor:publish --provider="Goedemiddag\ReCaptcha\ReCaptchaServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
    'site_key' => env('RECAPTCHA_SITE_KEY'),

    'secret_key' => env('RECAPTCHA_SECRET_KEY'),

    'threshold' => env('RECAPTCHA_THRESHOLD', 0.3),

    'skip_ips' => [
        // 127.0.0.1
    ],
];
```

## Usage

Add the `<x-recaptcha::input />` blade component to your form:

```blade
<form method="POST">
    @csrf
    <x-recaptcha::input />
    
    ... 
    
    <button type="submit">Submit</button>
</form>
```

Add the `<x-recaptcha::script />` blade component to your end of your layout:

```blade
<body>
    ...page content...

    <x-recaptcha::script />
</body>
```

Bind an event listener to the form submit event:

```js
document.querySelector('form').addEventListener('submit', function (event) {
    event.preventDefault();
    
    window.reCaptcha.render('submit', function (token) {        
        // Set token value
        event.target.querySelector('input[name="g-recaptcha-response"]').value = token;
        
        // Submit form
        event.target.submit();        
    });
});
```

Add the `ReCaptchaRule` to your form request:

```php
public function rules(): array
{
    return [
        'g-recaptcha-response' => ['required', new ReCaptchaRule()],
    ];
}
```
