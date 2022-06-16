# Application Skeleton

## Requirements

- PHP `>= v8.1` and Composer `>= v2.0`
- Node.js `>= v16.0` and Yarn `v1.x`
- Database Server (MySQL or PostgreSQL)

## Setup

1. Clone the repository & `cd` into it
   ```shell
   $ git clone git@github.com:creasico/skeleton.git <dir-name>
   $ cd <dir-name>
   ```
2. Install dependencies
   ```shell
   $ composer install
   $ yarn
   ```
3. Copy `.env.example` file to `.env` file & generate new app key
   ```shell
   $ php artisan key:generate
   ```
4. Create new database & make sure to update `.env` file accordingly
   ```shell
   $ mysql -e 'create database <db-name>
   ```
5. You're good to go

## Testing

All you need to do is prepare another database for testing, it could be anything. Then you can copy your existing `.env` to `.env.testing` and update your `DB_CONNECTION` accordingly. To simplify the process let's use `sqlite` for our testing.

```shell
$ cp .env .env.testing
$ touch database/database.sqlite
```

Make sure to replace all your `DB_*` from your `.env.testing` into this

```shell
DB_CONNECTION='sqlite'
```

Now you're good to go. For more information please consult to the [official documentation](https://laravel.com/docs/9.x/testing#environment).

## Development

This project is using `tailwind.css` and `alpine.js` as main front-end library, which mean any changes you've made, won't appears immadiately unless you run the following command
```shell
$ yarn watch
```

So, please make sure you've already install the dependencies as stated in the [Setup](#setup) section above.

## License

The Application will be open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
