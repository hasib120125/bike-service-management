# Bike Service Management

> A Bike Service Management.

## Features

-   Laravel 12
-   Vue 3 + VueRouter + Tailwind CSS + ESlint
-   Pages with dynamic import and custom layouts
-   Tailwind CSS

## Installation

-   `composer create-project --prefer-dist hasib120125/bike-service-management`
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

## Testing

```bash
# Run unit and feature tests
vendor/bin/phpunit

# Run Dusk browser tests
php artisan dusk
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.
