[![Version](https://img.shields.io/packagist/v/creasi/laravel-project?style=flat-square)](https://packagist.org/packages/creasi/laravel-project)
[![License](https://img.shields.io/packagist/l/creasi/laravel-project?style=flat-square)](https://github.com/creasico/laravel-project/blob/master/LICENSE)
[![Actions Status](https://img.shields.io/github/workflow/status/creasico/laravel-project/Code%20Quality/master?style=flat-square&logo=github-actions)](https://github.com/creasico/laravel-project/actions)

# Application Skeleton

## Requirements

- PHP `>= v8.0` and Composer `>= v2.0`
- Node.js `>= v16.0` and PNPM `v7.x`
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
   $ pnpm install
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

This project is using `windi.css` and `alpine.js` as main front-end library, which mean any changes you've made, won't appears immadiately unless you run the following command
```shell
$ pnpm watch
```

So, please make sure you've already install the dependencies as stated in the [Setup](#setup) section above.

**NOTES**:
- **Commit Convention**: This project follows [Conventional Commits](https://www.conventionalcommits.org/en/v1.0.0/) using [@commitlint/config-conventional](https://github.com/conventional-changelog/commitlint/tree/master/@commitlint/config-conventional) as standart, so make sure you follow the rules.
- **Code Style**: This project uses [`PSR12`](https://www.php-fig.org/psr/psr-12/) code standard and [`@antfu/eslint-config`](https://github.com/antfu/eslint-config), so make sure you follow the rules. But don't worry, your VSCode should handle it for you. Please consult to [this config](.vscode/settings.json) for more info.

## License

The Application will be open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
