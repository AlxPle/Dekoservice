@servers(['web' => 'root@dekoservice-kunz.de'])

@setup
$repository = 'git@github.com:YOUR_GITHUB_USER/dekoservice.git';
$appDir = '/var/www/dekoservice';
$release = date('YmdHis');
$releasePath = $appDir . '/releases/' . $release;
$currentPath = $appDir . '/current';
$sharedPath = $appDir . '/shared';
@endsetup

@story('deploy')
update_code
install_dependencies
setup_env
build_assets
run_migrations
optimize
activate_release
restart_queue
cleanup
@endstory

@task('update_code', ['on' => 'web'])
echo "--- Cloning release {{ $release }} ---"
[ -d {{ $appDir }}/releases ] || mkdir -p {{ $appDir }}/releases
git clone --depth 1 {{ $repository }} {{ $releasePath }}
@endtask

@task('install_dependencies', ['on' => 'web'])
echo "--- Installing Composer dependencies ---"
cd {{ $releasePath }}
composer install --no-dev --optimize-autoloader --no-interaction
@endtask

@task('setup_env', ['on' => 'web'])
echo "--- Linking .env and storage ---"
ln -nfs {{ $sharedPath }}/.env {{ $releasePath }}/.env
rm -rf {{ $releasePath }}/storage
ln -nfs {{ $sharedPath }}/storage {{ $releasePath }}/storage
php {{ $releasePath }}/artisan storage:link
@endtask

@task('build_assets', ['on' => 'web'])
echo "--- Building frontend assets ---"
cd {{ $releasePath }}
npm ci --prefer-offline
npm run build
@endtask

@task('run_migrations', ['on' => 'web'])
echo "--- Running migrations ---"
php {{ $releasePath }}/artisan migrate --force
@endtask

@task('optimize', ['on' => 'web'])
echo "--- Optimizing ---"
php {{ $releasePath }}/artisan config:cache
php {{ $releasePath }}/artisan route:cache
php {{ $releasePath }}/artisan view:cache
@endtask

@task('activate_release', ['on' => 'web'])
echo "--- Activating release {{ $release }} ---"
ln -nfs {{ $releasePath }} {{ $currentPath }}
@endtask

@task('restart_queue', ['on' => 'web'])
echo "--- Restarting queue workers ---"
php {{ $currentPath }}/artisan queue:restart
sudo systemctl reload php8.4-fpm
sudo systemctl reload nginx
@endtask

@task('cleanup', ['on' => 'web'])
echo "--- Cleaning up old releases (keeping 5) ---"
ls -dt {{ $appDir }}/releases/* | tail -n +6 | xargs rm -rf
@endtask

@task('rollback', ['on' => 'web'])
echo "--- Rolling back ---"
cd {{ $appDir }}/releases
ln -nfs $(ls -dt */ | sed -n '2p') {{ $currentPath }}
echo "Rolled back to $(ls -dt {{ $appDir }}/releases/* | sed -n '2p')"
@endtask