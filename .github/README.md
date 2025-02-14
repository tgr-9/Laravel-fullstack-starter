# Laravel Full Stack Starter

## Requirements

- PHP `>= v8.1` and Composer `>= v2.0`
- Node.js `>= v16.0` and PNPM `v8.x`
- Database Server (MySQL, MariaDB or PostgreSQL)

### Stacks
- [Laravel v10](https://laravel.com/docs/10.x)
- [Vue.js v3](https://vuejs.org)
- [Inertia.js](https://inertiajs.com)
- [Windi.css](https://windicss.org)

## Setup

1. Clone the repository and `cd` into it

   ```shell
   git clone git@github.com:tgr-9/Laravel-fullstack-starter.git my-project && cd $_
   ```
2. Install `composer` and `pnpm` dependencies
3. Copy `.env.example` file to `.env` file & generate new app key
4. Create new database and update your `.env` file accordingly

   ```shell
   # for MySQL (presumably you've already have mysql client)
   $ mysql -e 'create database <db-name>'

   # for PostgreSQL (presumably you've already have postgresql client)
   $ createdb <db-bame>
   ```
5. All things set? then run

   ```shell
   $ php artisan migrate --seed  # run database migration
   $ pnpm build                  # compile front-end assets
   ```
6. You're good to go

## Development

### Front-end

This project is using [`windi.css`](https://windicss.org/) and [`vue.js`](https://vuejs.org/) with [`inertia.js`](https://inertiajs.com/) as default front-end library, which mean any changes you've made, won't appears immadiately unless you run the following command

```shell
$ pnpm dev
```

## Testing

This skeleton is already have pre-configured for testing using built-in and official testing utility of Laravel Framework, which is `phpunit` and `laravel dusk`.

### Unit Tests

All we need to do is spare another database for testing. The reason behind it is while we run our tests, it will reset all of our existing development database. For more information please consult to the [official documentation](https://laravel.com/docs/testing#environment).

Once you've create new database, you can copy your `.env` file to `.env.testing` and update the database configuration with the newly created database.

```shell
$ composer test:unit       # to run unit test
```

### Integration Tests

Before you begin tests using laravel dusk, please make sure you've already install the webdriver with the following command

```shell
$ php artisan dusk:chrome-driver --detect
```

By default that command will install the latest ChromeDriver meaning you'll have to make sure that the installed version of ChromeDriver matches with version of your locally installed Google Chrome, then run

```shell
$ composer test:e2e        # to run end-to-end test using larvel-dusk
```

By default laravel dusk will runs headlessly, if you willing to disable headless mode, just uncomment `DUSK_HEADLESS_DISABLED` in your `.env.testing` file. For more info please consult to the [official documentation](https://laravel.com/docs/dusk)

> **Note**
> The `.env.example` also preconfigured with `BROWSERSTACK_USERNAME` and `BROWSERSTACK_ACCESS_KEY` which is necessary to run integration testing on [BrowserStack](https://automate.browserstack.com/), feel free to comment out those variables if you don't want to run it locally. Please consult to their official [documentation](https://www.browserstack.com/docs/local-testing) for local testing.

## Contributing
- **Commit Convention**: This project follows [Conventional Commits](https://www.conventionalcommits.org/en/v1.0.0/) using [@commitlint/config-conventional](https://github.com/conventional-changelog/commitlint/tree/master/@commitlint/config-conventional) as standart, so make sure you follow the rules.
- **Code Style**: This project uses [`Laravel Pint`](https://laravel.com/docs/pint) with `laravel` preset and [`@antfu/eslint-config`](https://github.com/antfu/eslint-config) as coding standard, so make sure you follow the rules. But don't worry, your VSCode should handle it for you. Please consult to [this config](.vscode/settings.json) for more info.
