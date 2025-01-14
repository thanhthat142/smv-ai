### Step to work with this project template

1. Create from laravel 10 with command
```textmate
/opt/homebrew/opt/php@8.1/bin/php /usr/local/bin/composer create-project laravel/laravel:^10.0 ~/Codes/php/backpack_latest
```
2. Copy `composer.json` and `.envrc` and `auth.json` from old project which already run backpack pro 6.x
3. Run composer install
```
direnv allow
rm -rf composer.lock
rm -rf vendor
composer install
```
3. Each component install

telescope, backpack, basset

```textmate
CREATE DATABASE backpack_latest CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
change .env

run php artisan migrate to migrate for basic table laravel
```
4. Run `php artisan backpack:install` to install or choose backpack theme and create admin user thienkimlove@gmail.com/tieungao
5. Change `.env` as below to install basset
```textmate

BASSET_DISK="basset"
BASSET_VERIFY_SSL_CERTIFICATE=false

ANd APP_URL=http://127.0.0.1:8000
and run again
composer require backpack/basset
```
6. INstall telescope
   After that we will install laravel opcache as below

```textmate
composer require appstract/laravel-opcache
php artisan vendor:publish --provider="Appstract\Opcache\OpcacheServiceProvider" --tag="config"
edit config/opcache.php and set verify=false,
change .env APP_URL to correct url
and restart php7.3-fpm to take affected.
RUn php artisan opcache:config
php artisan opcache:status
```
7. install redis cache
```textmate
composer require predis/predis
Not add 
CACHE_DRIVER=redis because local not has redis but in production ok

```

8. Install permission manager
 link  https://github.com/Laravel-Backpack/PermissionManager
```textmate
In your terminal:

composer require backpack/permissionmanager
Finish all installation steps for spatie/laravel-permission, which has been pulled as a dependency. Run its migrations. Publish its config files. Most likely it's:
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="permission-migrations"
php artisan migrate
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="permission-config"
// then, add the Spatie\Permission\Traits\HasRoles trait to your User model(s)

Publish backpack\permissionmanager config file & the migrations:
php artisan vendor:publish --provider="Backpack\PermissionManager\PermissionManagerServiceProvider" --tag="config" --tag="migrations"
Note: We recommend you to publish only the config file and migrations, but you may also publish lang and routes.

Run the migrations:
php artisan migrate

use Backpack\CRUD\app\Models\Traits\CrudTrait; // <------------------------------- this one
use Spatie\Permission\Traits\HasRoles;// <---------------------- and this one
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use CrudTrait; // <----- this
    use HasRoles; // <------ and this
[Optional] Add a menu item for it in resources/views/vendor/backpack/ui/inc/menu_items.blade.php:
<x-backpack::menu-dropdown title="Add-ons" icon="la la-puzzle-piece">
    <x-backpack::menu-dropdown-header title="Authentication" />
    <x-backpack::menu-dropdown-item title="Users" icon="la la-user" :link="backpack_url('user')" />
    <x-backpack::menu-dropdown-item title="Roles" icon="la la-group" :link="backpack_url('role')" />
    <x-backpack::menu-dropdown-item title="Permissions" icon="la la-key" :link="backpack_url('permission')" />
</x-backpack::menu-dropdown>
```
9. Add settings addon
```textmate
https://github.com/Laravel-Backpack/Settings
```
10. add more addon
```textmate
https://backpackforlaravel.com/docs/6.x/add-ons-official
```
## addition command 


```textmate
php artisan optimize:clear   run after change .env in production mode
php artisan basset:clear && php artisan basset:cache  clear cache
git fetch && git pull && php artisan opcache:clear
mkdir -p /var/www/html/demo/storage/app/public/basset run on server
sudo apt install certbot python3-certbot-nginx
certbot --nginx -d demo.tnet.vn
```
