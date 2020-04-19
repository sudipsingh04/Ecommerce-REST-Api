# Laravel Ecommerce 🛰 API

This is a Ecommerce REST Api built with the [Laravel](https://laravel.com/) and integrated with [Passport](https://laravel.com/docs/5.8/passport) authentication.

## Usage

1. Clone this repository
`git clone https://github.com/sudipsingh04/Ecommerce-REST-Api.git`
2. Run `composer install` to install the dependencies.
3. Run `php artisan key:generate`
4. Configure your database in `.env` file.
5. Generate client id and client secret 
`php artisan passport:install`
6. Run migration to create tables in database.
`php artisan migrate --seed`
7. Final step run project server.
`php artisan serve`
8. Download and import `ecommerceApi.postman_collection.json` in postman to test the api endpoints.
