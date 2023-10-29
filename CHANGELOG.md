# Changelog

All notable changes to this project will be documented in this file. See [standard-version](https://github.com/conventional-changelog/standard-version) for commit guidelines.

### [0.1.1](https://github.com/creasico/laravel-project/compare/v0.1.0...v0.1.1) (2023-10-29)


### Features

* **ci:** switch `release` and `deploy` workflow trigger ([bafb38a](https://github.com/creasico/laravel-project/commit/bafb38ab54e44cfdc3b1e2c19939e51b7b740daa))

## [0.1.0](https://github.com/creasico/laravel-project/compare/v0.0.3...v0.1.0) (2023-10-28)


### ⚠ BREAKING CHANGES

* rename directory of `composables` to `utils` for the sake of common sense

### Features

* add `app-wrapper` component ([ee02f99](https://github.com/creasico/laravel-project/commit/ee02f99a22635cfa98b0a65231d319bb213934c6))
* add ability load layout by name ([69512ae](https://github.com/creasico/laravel-project/commit/69512ae71c1e3c38d4f14331e434308b279db0ad))
* add ability to load async app module ([20535cb](https://github.com/creasico/laravel-project/commit/20535cb2d35b3d642cbd57d94413c6e1f5de3ab2))
* add ability to load laravel' `.php` translation to frontend ([b0a900d](https://github.com/creasico/laravel-project/commit/b0a900d8294ba2c1ce1869d00c1af4b2ba947a47))
* add ability to toggle color schema ([ccae7d4](https://github.com/creasico/laravel-project/commit/ccae7d4f9adfca0977433cfee9b6d71678d2e881))
* add inertia shared data ([07dfffd](https://github.com/creasico/laravel-project/commit/07dfffd9f28c3b5146e0f54265eb82ad9d120c43))
* add page expiration handler ([cb307b9](https://github.com/creasico/laravel-project/commit/cb307b941cf566b6ead32390ab093fb8e27d5c2e))
* add responsiveness to `app-layout` ([ca38da8](https://github.com/creasico/laravel-project/commit/ca38da82978a44453b65b7212d9d8df6360ceb19))
* add support for menu `group` and `devider`, even tho `devider` still not working properly ([5a57f29](https://github.com/creasico/laravel-project/commit/5a57f29e5a1797709a84ef13a04a68da55e5fbd7))
* add utility file for the sake of why not ([79ef873](https://github.com/creasico/laravel-project/commit/79ef87355c3650b47ddb9674f2baca5b3b549bbf))
* better type definition for `Ziggy.routes` ([597f1f7](https://github.com/creasico/laravel-project/commit/597f1f76115c1caabb0857ae44ad2b8612f3ebe1))
* better type definition for global `axios()` ([4956d47](https://github.com/creasico/laravel-project/commit/4956d4717b4b54db6d34738cc36d27411a0d3dfa))
* **ci:** add `release` config ([4e7448c](https://github.com/creasico/laravel-project/commit/4e7448c8741e1c8d674158890f62668b6f579fb0))
* **ci:** add `release` workflow to add notes from `CHANGELOG.md` ([05f14bd](https://github.com/creasico/laravel-project/commit/05f14bde71a5e488dc456e2f2b81f32356bf5aa6))
* **ci:** add `triage` workflow that will triggered on all PR ([7a4d33d](https://github.com/creasico/laravel-project/commit/7a4d33d742583ff04903267f2c241ab86cfb445f))
* **ci:** add dependabot config ([7a750dd](https://github.com/creasico/laravel-project/commit/7a750dd1690b236a8786bd1863b2f50348e74b20)), closes [creasico/laravel-package#69](https://github.com/creasico/laravel-package/issues/69)
* **ci:** rewrite ci config and make them more reusable ([5e4af53](https://github.com/creasico/laravel-project/commit/5e4af53ee4509b3789c868e5fe7aeaff5b11128f))
* **ci:** workaround with `workflow_dispatch` for deployment ([e930930](https://github.com/creasico/laravel-project/commit/e9309305ba5804a721f43bb9ad464251f7269631))
* **dev:** enable debug config ([89d0c1e](https://github.com/creasico/laravel-project/commit/89d0c1e25acb6fd2b58254cd15cde9895eaeba73))
* enable naive-ui discrete api ([6890392](https://github.com/creasico/laravel-project/commit/689039227e10f9fe81cfe25aade273de8bdaea1d))
* enable sentry profiling and session replay ([10ccea0](https://github.com/creasico/laravel-project/commit/10ccea05710643689df3c09a8c100956d13fc2c3))
* force cli output to ansi ([8428cd5](https://github.com/creasico/laravel-project/commit/8428cd53da8a19f34140ee18eb05b898f736d3bd))
* initialize `account.home`, `account.settings` and `supports.home` routes ([ca52cea](https://github.com/creasico/laravel-project/commit/ca52ceacb86f1a1c9e6b7022553bd9cc2aea02be))
* initialize `creasi/laravel-base` ([6750cc8](https://github.com/creasico/laravel-project/commit/6750cc847363af65056d8cc89d7c9ca587ecae4e))
* initialize `creasi/laravel-nusa` ([480c9bf](https://github.com/creasico/laravel-project/commit/480c9bfb418d495812c612008597f2e91b4e5ecc))
* initialize `deployphp/action` as deployment tool ([c1f3a5e](https://github.com/creasico/laravel-project/commit/c1f3a5e1cdfc3c7e3df31a3537949d2918e1194d))
* initialize codeclimate integrations ([ae12989](https://github.com/creasico/laravel-project/commit/ae1298949967661faf5c1e1d3b95a4142276ac99))
* initialize custom service-worker script ([d22a146](https://github.com/creasico/laravel-project/commit/d22a1462b778a9345a81e0e7047a3ee5c0290e3d))
* initialize dedicated translation view composer class ([3ffc4ee](https://github.com/creasico/laravel-project/commit/3ffc4ee3505ba1d82612c56bb26077f33d75cb73))
* initialize naive-convig-provider to help manage locale and global theme config ([84ff858](https://github.com/creasico/laravel-project/commit/84ff85845d6ee5b6f75f01a2b4b2ecf3c5f988c2))
* initialize naive-ui theme overrides ([13da4ce](https://github.com/creasico/laravel-project/commit/13da4cecb855bce36ba81aa60bebb5cf92e45a48))
* initialize navigation view composer ([010dad5](https://github.com/creasico/laravel-project/commit/010dad58eddfc5c953039218b59c4c4886a7d210))
* initialize user management pages ([d9d7bab](https://github.com/creasico/laravel-project/commit/d9d7bab9d3ccf60a7e1ffae36a5661d7b7ab9857))
* initialize user menu ([1ac4052](https://github.com/creasico/laravel-project/commit/1ac4052b7cd8817b8da63f03df8a675e540a8da0))
* initialize validation status and form feedback ([04f8313](https://github.com/creasico/laravel-project/commit/04f83136e8c5607799d6999b4f5c7899ce119e8c))
* initilize `inertia-vue` ([db9e6e0](https://github.com/creasico/laravel-project/commit/db9e6e08e49a5d7281c5175aef3d242ebd418e3e))
* initilize another user menus and update translation ([5f55435](https://github.com/creasico/laravel-project/commit/5f55435bf5dde3110d1d0a1770b17eccbe18215d))
* load app background image for the guest pages ([265989b](https://github.com/creasico/laravel-project/commit/265989bcdb01fe0e38a81e0de4c19b33e015cf33))
* make use of `defineOptions()` to assign page title ([1092c6e](https://github.com/creasico/laravel-project/commit/1092c6e3aaa03067e466ca09c29f6b0ac481f14e))
* simplify usage and initiation of app modules ([fd2af30](https://github.com/creasico/laravel-project/commit/fd2af30ecd2bbc4139cc749d12c0c17258832dbf))
* store sidebar collapse state to session storage ([d09a8c6](https://github.com/creasico/laravel-project/commit/d09a8c6a5998341a5a7f2f925d30e2836635be1f))
* switch main logo on sider collapsed ([48e6aa5](https://github.com/creasico/laravel-project/commit/48e6aa595741de6f0e10c7afbbc727b1fa38056b))
* **ui:** improve accessibility on auth forms ([ed075b2](https://github.com/creasico/laravel-project/commit/ed075b29eea957819881e7cb8d7985eba0e44bd2))


### Bug Fixes

* **ci:** apparently `github.env.APP_ENV` only works few area ([2468369](https://github.com/creasico/laravel-project/commit/2468369907fb69d4659f4053c9962015f073c1cd))
* **ci:** apparently we can't access artifacts from other workflows ([acc203a](https://github.com/creasico/laravel-project/commit/acc203ad83966c8a8da08bd13d3de012a70dc2c0))
* **ci:** fix deployment issues caused by missing files ([3e11196](https://github.com/creasico/laravel-project/commit/3e111968dcb47ad08f19300a0dd3c84c4bf79aa7))
* **ci:** fix my stupidity to execute `composer ziggy:generate` before build ([f7de4dc](https://github.com/creasico/laravel-project/commit/f7de4dc7e21a8b627db2b3f6f64c29baa1506559))
* **ci:** try to fix [#50](https://github.com/creasico/laravel-project/issues/50) ([8caf292](https://github.com/creasico/laravel-project/commit/8caf292b38964fb84db9b1326b7e2e5683a71d29))
* **deploy:** fix deployment issue when executing `post-autoload-dump` command ([8a2f4bf](https://github.com/creasico/laravel-project/commit/8a2f4bfa3d9a43a4c1ec9bdd468ccf7e5679461f))
* **deploy:** fix deployment issue with `public/vendor` assets ([bd2a7f2](https://github.com/creasico/laravel-project/commit/bd2a7f2fbbe92bd99f9b452951945e6de68c1e9a)), closes [#30](https://github.com/creasico/laravel-project/issues/30)
* **docs:** fix documentation issue and `.env.example` file ([6d4d1d0](https://github.com/creasico/laravel-project/commit/6d4d1d0b464471f2579c0b7aa5a382e31751ae59))
* fix `Unexpected lexical analysis` issue in `vue-i18n` module ([3b4ae5b](https://github.com/creasico/laravel-project/commit/3b4ae5b355f2041a8aa81c80304803722a0d0da7)), closes [intlify/vue-i18n-next#363](https://github.com/intlify/vue-i18n-next/issues/363)
* fix main menu state when user currently on account pages ([86f67cf](https://github.com/creasico/laravel-project/commit/86f67cffb39cf732171b9b0b22efc108a4677a8d))
* fix my stupidity ([0c80de5](https://github.com/creasico/laravel-project/commit/0c80de5cf366837ac8da4a7b97cfd68786ce743d))
* quick fix for logout functionality ([d1e749d](https://github.com/creasico/laravel-project/commit/d1e749d126a5fe2dfe5a2aece8333166c29f5eae))
* **tests:** fix end-to-end test on browserstack ([f189e7a](https://github.com/creasico/laravel-project/commit/f189e7ae700023b2f242de54759ef46a2add0713))
* **ui:** fix ugly styling on light mode ([7dba66b](https://github.com/creasico/laravel-project/commit/7dba66baf988bdea2c574025d5225d372f10c48f)), closes [#39](https://github.com/creasico/laravel-project/issues/39)
* **ux:** fix form submission handling issue ([e96e4e0](https://github.com/creasico/laravel-project/commit/e96e4e08d9d7730fe4a66bd4cb0f3011c8c417f1)), closes [#32](https://github.com/creasico/laravel-project/issues/32)
* workaround with inertia integration for end-to-end testing with laravel dusk ([b6a5ddf](https://github.com/creasico/laravel-project/commit/b6a5ddf53b63ed6bc89a1b9b31765c3f892da110)), closes [/github.com/creasico/laravel-project/pull/21#issuecomment-1620517727](https://github.com/creasico//github.com/creasico/laravel-project/pull/21/issues/issuecomment-1620517727)


* rename directory of `composables` to `utils` for the sake of common sense ([d85e131](https://github.com/creasico/laravel-project/commit/d85e1317fb39331acf2a3bfd34ae40c954b4491a))

### 0.0.3 (2023-06-26)


### Features

* add bare minimum nginx vhost config as a reference ([fbf3b88](https://github.com/creasico/laravel-project/commit/fbf3b88babbd3860ca79b2af08176fc3b19a3c01))
* add Laravel Blade Snippets as vscode extension recommendation ([c1fd537](https://github.com/creasico/laravel-project/commit/c1fd537caead98f2758577687b435ce7232164d0))
* **ci:** only run integration test on php 8.0 ([ef4d9a2](https://github.com/creasico/laravel-project/commit/ef4d9a23f1be07cac3ac620b02f02c2918312e42))
* define `APP_NAME`, `APP_LOCALE` and `APP_URL` to front-end ([11a995b](https://github.com/creasico/laravel-project/commit/11a995b7d7bdc4e5be402b22d0755430cd2951a8))
* **dev:** add `APP_ENV` variable with default to `id` ([3b81682](https://github.com/creasico/laravel-project/commit/3b816827ec4d21fa862b29fe0429c6a74aae3479))
* **frontend:** refactor frontend directory structures ([a7a3921](https://github.com/creasico/laravel-project/commit/a7a39210211e78a2d0414b93060199e93c944fd3))
* initialize `standard-version` to help manage release versions ([4093580](https://github.com/creasico/laravel-project/commit/40935801021b009f12038508eee3709eca3b29ee))
* initialize `vite-plugin-pwa` ([2df4ed4](https://github.com/creasico/laravel-project/commit/2df4ed479b486f4814c06cdd8782488a0fa60594))
* **test:** use dedicated package ([4be7463](https://github.com/creasico/laravel-project/commit/4be7463ab62c8a22bfe4cf3bdeacd9948ff036b1))


### Bug Fixes

* **ci:** fix build cannot be more than 255 characters issue ([5065aaf](https://github.com/creasico/laravel-project/commit/5065aaf176afb386329cf648ba858375a3121eeb))
* **dev:** fix `windi.config.ts` file due to linting issue ([c9db2ad](https://github.com/creasico/laravel-project/commit/c9db2adb187814a09f960780c37bb1793eba3175))
* **route:** fix route loading issue ([fb20ff5](https://github.com/creasico/laravel-project/commit/fb20ff51b42cc08ed0a79e90b3f463e3a8e9b084))
* **test:** fix dusk headless indicator ([9efb565](https://github.com/creasico/laravel-project/commit/9efb5658d5524d77ce2378bb6121235260b8850c))
* **test:** fix false-positive issue on browserstack ([6665313](https://github.com/creasico/laravel-project/commit/6665313058c82d72d378260a13d7a8bf226de6b1)), closes [#16](https://github.com/creasico/laravel-project/issues/16)
* **test:** fix test failing test due to prior changes ([275c2f3](https://github.com/creasico/laravel-project/commit/275c2f3b4c901a36511dfb9d71e5af1c9e4e5e2e))
