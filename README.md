# Lockbox

## Introduction

a `.env` file is an easy way to load custom configuration variables that your application needs without having to modify `.htaccess` files or Apache/nginx virtual hosts.

## Installation

This library uses `vlucas/phpdotenv` library by [Vance Lucas](https://github.com/vlucas) & [Graham Campbell](https://github.com/GrahamCampbell). So, keep in mind that you may want to include `vlucas/phpdotenv` as a dependency to use this library.

Installation made easy via [Composer](https://getcomposer.org/):

```bash
$ composer require emberfuse/lockbox
```

or add it by hand to your `composer.json` file.

## Usage

Add your application configuration to a `.env` file at the root of your project. **Make sure the `.env` file is added to your `.gitignore` so it is not checked-in the code**

```shell
API_TOKEN="you-shall-not-pass"
SECRET_KEY="itsunderthemattress"
```

Before using **Lockbox** you need to load up all your environment variables. To do so you will have to use `vlucas/phpdotenv` in the following way:

```php
$dotenv = Dotenv\Dotenv::create(
    Emberfuse\Lockbox\Env::createRepository(), // The repository where all environment variables are saved.
    __DIR__, // Full path to where the environment file is located.
    '.env' // Environment file.
);

$dotenv->load(); // Load them all up.
```

For more information on how to use `vlucas/phpdotenv` check out the full documentation [here](https://github.com/vlucas/phpdotenv).

The above example will write loaded values to `$_ENV` and `putenv`, but when interpolating environment variables, we'll only read from `$_ENV`. Moreover, it will never replace any variables already set before loading the file.

Now that your environment variables are loaded up you may access them using the following method.

```php
use Emberfuse\Lockbox\Env;

return [
    'database' => [
        'name' => Env::get('DB_NAME', 'default_db_name'),
    ],
];
```

You may also use the helper methods provided to do the same as above.

```php
return [
    'database' => [
        'name' => env('DB_NAME', 'default_db_name'),
    ],
];
```

## Contributing

Thank you for considering contributing to Lockbox! You can read the contribution guide [here](.github/CONTRIBUTING.md).

## Code of Conduct

To ensure that the Emberfuse community is welcoming to all, please review and abide by the [Code of Conduct](.github/CODE_OF_CONDUCT.md).

## Security Vulnerabilities

Please review [our security policy](https://github.com/emberfuse/Lockbox/security/policy) on how to report security vulnerabilities.

## License

Emberfuse Lockbox is open-sourced software licensed under the [MIT license](LICENSE).
