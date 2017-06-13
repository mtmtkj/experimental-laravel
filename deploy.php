<?php
namespace Deployer;

require 'recipe/laravel.php';

// Configuration

set('repository', 'git@github.com:mtmtkj/experimental-laravel.git');
set('git_tty', true); // [Optional] Allocate tty for git on first deployment

// Hosts

host('experimental-laravel.usingstd.com')
    ->stage('production')
    ->set('deploy_path', '/var/www/sites/experimental-laravel');

host('serverman')
    ->stage('staging')
    ->set('deploy_path', '/var/www/sites/experimental-laravel');

// Tasks

// desc('Restart PHP-FPM service');
// task('php-fpm:restart', function () {
//     // The user must have rights for restart service
//     // /etc/sudoers: username ALL=NOPASSWD:/bin/systemctl restart php-fpm.service
//     run('sudo systemctl restart php-fpm.service');
// });
// after('deploy:symlink', 'php-fpm:restart');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');
