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

task('deploy:assets', function () {
    $conn = currentHost()->connectionString();

    runLocally("rsync -zrtv --exclude '*.map' ../public/{build,vendor} {$conn}:{{release_or_current_path}}/public/");
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
