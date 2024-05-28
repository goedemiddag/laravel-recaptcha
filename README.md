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

### Config

You can optionally publish the config file:

```bash
php artisan vendor:publish --provider="Goedemiddag\ReCaptcha\ReCaptchaServiceProvider" --tag="recaptcha-config"
```

This is the contents of the published config file:

```php
return [
    'site_key' => env('RECAPTCHA_SITE_KEY'),
    'secret_key' => env('RECAPTCHA_SECRET_KEY'),

    // The threshold to pass the recaptcha validation, from 0 (easiest) to 1 (hardest)
    'threshold' => env('RECAPTCHA_THRESHOLD', 0.3),

    // Provide IP addresses that shouldn't be validated
    'skip_ips' => [
        // 127.0.0.1
    ],
];
```

### Translations

This package offers Dutch and English translations by default. You can optionally publish the translations:

```bash
php artisan vendor:publish --provider="Goedemiddag\ReCaptcha\ReCaptchaServiceProvider" --tag="recaptcha-lang"
```

## Usage

This package aims to provide the Google ReCaptcha v3 validation in the backend of your application and offers some tools to use it in the frontend.

### Quick start

Add the `<x-recaptcha::input />` blade component to your form:

```bladehtml
<form method="POST">
    @csrf
    <x-recaptcha::input />
    
    ... 
    
    <button type="submit">Submit</button>
</form>
```

Add the `<x-recaptcha::script />` blade component to your end of your layout:

```bladehtml
<body>
    ...page content...

    <x-recaptcha::script />
</body>
```

Bind an event listener to the form submit event, please adjust this for your application:

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

## Contributing

Found a bug or want to add a new feature? Great! There are also many other ways to make meaningful contributions such as reviewing outstanding pull requests and writing documentation. Even opening an issue for a bug you found is appreciated.

When you create a pull request, make sure it is tested, following the code standard (run `composer pint:fix` to take care of that for you) and please create one pull request per feature. In exchange, you will be credited as contributor.
