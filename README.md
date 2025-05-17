# Laravel-Vue SPA Starter Kit

> A Laravel-Vue SPA starter kit.

## Features

-   Laravel 12
-   Vue 3 + VueRouter + Vuex + Tailwind CSS + ESlint
-   Pages with dynamic import and custom layouts
-   Login, register, email verification and password reset
-   Authentication with Sanctum
-   Tailwind CSS

## Installation

-   `composer create-project --prefer-dist hasib120125/laravel-vue-spa-starter-kit`
-   Edit `.env` and set your database connection details
-   (When installed via git clone or download, run `php artisan key:generate`)
-   `php artisan migrate`
-   `npm install`

## Usage

#### Development

```bash
npm run dev
```

#### Production

```bash
npm run build
```

## Socialite

This project comes with GitHub as an example for [Laravel Socialite](https://laravel.com/docs/12.x/socialite).

To enable the provider create a new GitHub application and use `https://example.com/api/oauth/github/callback` as the Authorization callback URL.

Edit `.env` and set `GITHUB_CLIENT_ID` and `GITHUB_CLIENT_SECRET` with the keys form your GitHub application.

For other providers you may need to set the appropriate keys in `config/services.php` and redirect url in `OAuthController.php`.

## Email Verification

To enable email verification make sure that your `App\User` model implements the `Illuminate\Contracts\Auth\MustVerifyEmail` contract.

## Testing

```bash
# Run unit and feature tests
vendor/bin/phpunit

# Run Dusk browser tests
php artisan dusk
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.
