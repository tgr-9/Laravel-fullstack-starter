<?php

namespace Deployer;

$rootDir = \realpath(__DIR__.'/..');

require 'recipe/laravel.php';
require $rootDir.'/vendor/autoload.php';

// Config

set('repository', 'git@github.com:creasico/laravel-project.git');
set('keep_releases', 5);

add('shared_files', []);
add('shared_dirs', ['public/build', 'public/vendor']);
add('writable_dirs', ['storage']);

// Hosts

host('skeleton.creasi.dev')
    ->setHostname('creasi.dev')
    ->setRemoteUser('deployer')
    ->setDeployPath('/var/www/skeleton')
    ->setLabels(['env' => 'staging']);

// Tasks

task('deploy:assets', function () use ($rootDir) {
    $config = ['flags' => '-zrtv'];
    $env = get('labels')['env'] ?? null;
    $masterData = "{$rootDir}/storage/app/master-data.{$env}.xlsx";

    if (! \file_exists($masterData)) {
        $masterData = $rootDir.'/storage/app/master-data.xlsx';
    }

    if (\file_exists($masterData)) {
        upload($masterData, '{{release_or_current_path}}/storage/app', $config);
    }

    upload($rootDir.'/public/{build,vendor}', '{{release_or_current_path}}/public/', $config + [
        'options' => ['--exclude=*.map'],
    ]);
})->desc('Deploy static assets');

// Hooks

after('deploy:failed', 'deploy:unlock');

task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'deploy:assets',
    'artisan:storage:link',
    'artisan:optimize:clear',
    'artisan:down',
    'artisan:migrate:fresh',
    'artisan:db:seed',
    'artisan:up',
    'deploy:publish',
]);
