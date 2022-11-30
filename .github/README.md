[![Version](https://img.shields.io/packagist/v/creasi/skeleton)](https://packagist.org/packages/creasi/skeleton)
[![License](https://img.shields.io/packagist/l/creasi/skeleton)](https://github.com/creasico/laravel-project/blob/master/LICENSE)
[![Actions Status](https://github.com/creasico/laravel-project/actions/workflows/main.yml/badge.svg)](https://github.com/creasico/laravel-project/actions)

# Application Skeleton

## Requirements

- PHP `>= v8.0` and Composer `>= v2.0`
- Node.js `>= v16.0` and PNPM `v7.x`
- Database Server (MySQL, MariaDB or PostgreSQL)

## Setup

1. Clone the repository & `cd` into it
   ```sh
   $ git clone git@github.com:creasico/laravel-project.git <dir-name>
   $ cd <dir-name>
   ```
2. Install dependencies
   ```sh
   $ composer install
   $ pnpm install
   ```
3. Copy `.env.example` file to `.env` file & generate new app key
   ```sh
   $ php artisan key:generate
   ```
4. Create new database & make sure to update `.env` file accordingly
   ```sh
   # for MySQL (presumably you've already have mysql client)
   $ mysql -e 'create database <db-name>'

   # for PostgreSQL (presumably you've already have postgresql client)
   $ createdb <db-bame>
   ```

5. You're good to go

## Development

### Front-end

This project is using `windi.css` and `alpine.js` as default front-end library, which mean any changes you've made, won't appears immadiately unless you run the following command

```sh
$ pnpm dev
```

So, please make sure you've already install the dependencies as stated in the [Setup](#setup) section above.

## Testing

This skeleton is already have pre-configured for testing using built-in and official testing utility of Laravel Framework, which is `phpunit` and `laravel dusk`.

All we need to do is spare another database solely for testing purposes. The reason behind it is while we run our tests, it will reset all of our existing development database. For more information please consult to the [official documentation](https://laravel.com/docs/9.x/testing#environment).

Once you've create new database, you can copy your `.env` file to `.env.testing` and update the database configuration with the newly created database.

```sh
$ composer test:unit       # to run unit test
```

### Laravel Dusk

Before you begin tests using laravel dusk, please make sure you've already install the webdriver with the following command

```sh
$ php artisan dusk:chrome-driver --detect
```

By default that command will install the latest ChromeDriver meaning you'll have to make sure that the installed version of ChromeDriver matches with version of your locally installed Google Chrome, then run

```sh
$ composer test:e2e        # to run end-to-end test using larvel-dusk
```

By default laravel dusk will runs headlessly, if you willing to disable headless mode, just comment out `DUSK_HEADLESS_DISABLED` in your `.env.testing` file. For more info please consult to the [official documentation](https://laravel.com/docs/dusk)

## Notes
- **Commit Convention**: This project follows [Conventional Commits](https://www.conventionalcommits.org/en/v1.0.0/) using [@commitlint/config-conventional](https://github.com/conventional-changelog/commitlint/tree/master/@commitlint/config-conventional) as standart, so make sure you follow the rules.
- **Code Style**: This project uses [`PSR12`](https://www.php-fig.org/psr/psr-12/) code standard and [`@antfu/eslint-config`](https://github.com/antfu/eslint-config), so make sure you follow the rules. But don't worry, your VSCode should handle it for you. Please consult to [this config](.vscode/settings.json) for more info.

## Sponsors

[![BrowserStack Logo](https://raw.githubusercontent.com/creasico/creasico.github.io/master/public/assets/browserstack-logo.png)](https://browserstack.com)

## License

The project is an open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
