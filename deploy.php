<?php

namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'git@github.com:creasico/laravel-project.git');

add('shared_files', []);
add('shared_dirs', ['public/vendor']);
add('writable_dirs', ['storage']);

// Hosts

host('creasi.dev')
    ->set('remote_user', 'creasi')
    ->set('deploy_path', '/var/www/skeleton');

// Tasks

desc('Deploy static assets');
task('deploy:assets', function () {
    runLocally('rsync -zrtv public/build/* creasi.dev:{{release_path}}/public/build');
});

// Hooks

after('deploy:vendors', 'deploy:assets');
after('deploy:failed', 'deploy:unlock');

task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'artisan:storage:link',
    'artisan:optimize:clear',
    'artisan:down',
    'artisan:migrate:fresh',
    'artisan:db:seed',
    'artisan:up',
    'deploy:publish',
]);
