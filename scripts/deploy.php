<?php

namespace Deployer;

use Illuminate\Support\Env;
use Symfony\Component\Console\Input\InputOption;

$rootDir = \dirname(__DIR__);

require 'recipe/laravel.php';
require $rootDir.'/vendor/autoload.php';

// Config

add('shared_files', []);
add('shared_dirs', ['public/build', 'public/vendor']);
add('writable_dirs', []);

set('keep_releases', 3);

option('reset', null, InputOption::VALUE_NEGATABLE, 'Reset database', false);

// Hosts

host('skeleton.creasi.dev')
    ->setHostname('creasi.dev')
    ->setRemoteUser('deployer')
    ->setDeployPath('/var/www/skeleton')
    ->setLabels(['env' => 'staging']);

// Hooks

after('deploy:failed', 'deploy:unlock');
after('deploy:update_code', 'deploy:environment');

// Tasks

task('deploy:info', function () {
    set('repository', $repository = runLocally('git remote get-url origin'));
    set('pull_request', $pullRequest = null);
    set('original_deploy_path', $deployPath = get('deploy_path'));

    $env = get('labels')['env'] ?? null;
    $host = currentHost();
    $masterData = "storage/app/master-data.{$env}.xlsx";
    $appUrl = Env::get('APP_URL');
    $onGitHub = Env::get('GITHUB_ENV');

    set('master_data', \file_exists($masterData) ? $masterData : 'storage/app/master-data.xlsx');

    if (! $appUrl || \str_contains($appUrl, 'localhost')) {
        $appUrl = 'https://'.$host->getAlias();
    }

    if ($ghRef = Env::get('GITHUB_REF')) {
        [$_, $ref, $name] = explode('/', $ghRef);
        if ($ref === 'pull' && \is_numeric($name)) {
            $pullRequest = $name;
        }
    }

    $info = ['deploying <fg=magenta;options=bold>{{target}}</>'];

    if ($pullRequest !== null) {
        set('pull_request', (int) $pullRequest);
        set('deploy_path', $deployPath.'-'.$pullRequest);

        if (! \str_contains($appUrl, $pullRequest)) {
            $subdomain = \basename($deployPath);
            $appUrl = \str_replace($subdomain, $subdomain.'-'.$pullRequest, $appUrl);
        }

        $onGitHub && runLocally('echo "APP_ENV=preview-{{pull_request}}" >> $GITHUB_ENV');

        $info[] = 'from PR <fg=magenta;options=bold>#{{pull_request}}</>';
    }

    $onGitHub && runLocally('echo "APP_URL='.$appUrl.'" >> $GITHUB_ENV');
    $info[] = 'to <fg=magenta;options=bold>'.$appUrl.'</>';

    info(\implode(' ', $info));
    info('repository: <fg=magenta;options=bold>'.$repository.'</>');
})->desc('Check repository');

task('deploy:environment', function () {
    $releasesList = get('releases_list');
    $isPullRequest = get('pull_request') !== null;
    $isInitialDeploy = ((int) last($releasesList)) === \count($releasesList);

    if (! ($isInitialDeploy || $isPullRequest) || test("[ -s {{deploy_path}}/shared/.env ]")) {
        info("Your deployment already configured! Skipping...");
        return;
    }

    $dbName = str(get('deploy_path'))->basename()->slug('_');
    $envFile = $isPullRequest
        ? '{{original_deploy_path}}/current/.env'
        : '{{release_or_current_path}}/.env.example';

    info('initialize environment file');
    run("cat {$envFile} > {{release_path}}/.env");
    run("sed -i 's~;APP_ENV=.*~APP_ENV=preview~' {{release_path}}/.env");
    run("sed -i 's~;DB_DATABASE=.*~DB_DATABASE={$dbName}~' {{release_path}}/.env");

    if ($url = Env::get('APP_URL')) {
        run("sed -i 's~;APP_URL=.*~APP_URL={$url}~' {{release_path}}/.env");
    }

    set('dotenv', '{{release_path}}/.env');
    run('createdb -h "$DB_HOST" -U "$DB_USERNAME" -O "$DB_USERNAME" '.$dbName, env: [
        'DB_USERNAME' => Env::get('DB_USERNAME'),
        'PGPASSWORD' => Env::get('DB_PASSWORD'),
    ]);

    info('database <fg=magenta;options=bold>'.$dbName.'</> created');
})->desc('Setup deployment environment');

task('deploy:database', function () {
    if ($isInitialDeploy = (get('dotenv') !== false)) {
        invoke('artisan:key:generate');
    }

    if (! input()->getOption('reset')) {
        invoke('artisan:migrate');

        if ($isInitialDeploy) {
            invoke('artisan:db:seed');
        }

        return;
    }

    invoke('artisan:down');
    invoke('artisan:migrate:fresh');
    invoke('artisan:db:seed');
    invoke('artisan:up');
})->desc('Deploy database');

task('deploy:assets', function () {
    $config = ['flags' => '-zrtv'];

    if (\file_exists($masterData = get('master_data'))) {
        upload($masterData, '{{release_or_current_path}}/storage/app', $config);
    }

    upload('public/vendor', '{{release_or_current_path}}/public/', $config);
    upload('public/build', '{{release_or_current_path}}/public/', $config + [
        'options' => ['--exclude=*.map'],
    ]);
})->desc('Deploy static assets');

task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'deploy:assets',
    'artisan:storage:link',
    'artisan:optimize:clear',
    'deploy:database',
    'deploy:publish',
]);
