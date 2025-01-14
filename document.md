We can change `.env` to using sqlite database for quickly install

```textmate
DB_CONNECTION=sqlite
```

```textmate
 1200  composer install
 1201  php artisan key:generate
 1202  php artisan make:migrate
 1203  php artisan migrate
 1204  php artisan serve
 1205  php artisan backpack:user
 1206  php artisan serve

```

## Make sure basset work if website look wrong.

`env` and `env.example` must have line:

```textmate
BASSET_DISK="basset"
BASSET_VERIFY_SSL_CERTIFICATE=false
APP_URL=http://127.0.0.1:8000
```
has instance running and run `composer require backpack/basset`

and run `php artisan basset:clear && php artisan basset:cache`

Make sure `APP_URL=http://127.0.0.1:8000`

## start with multi languages

1. Install needed packages

```textmate
1019  php artisan backpack:crud category
1020  compose require backpack/language-switcher
1021  composer require backpack/language-switcher
1022  composer require backpack/translation-manager
1023  composer remove laravel/telescope
1024  composer remove laravel/telescope
1025  composer remove laravel/telescope
1026  composer require cviebrock/eloquent-sluggable
composer require spatie/laravel-translatable

```

2. Create migrate table and files needed for category

```textmate
1018  php artisan make:migration create_table_categories --create=categories
php artisan backpack:crud category
```
3. Follow laravel lang 

```textmate
https://laravel.com/docs/11.x/localization

By default, the Laravel application skeleton does not include the lang directory. 
If you would like to customize Laravel's language files, 
you may publish them via the lang:publish Artisan command
```

```textmate
 php artisan lang:publish
```

```textmate
[
    'vi' => 'VN',
    'en' => 'EN',
    'lo' => 'LO'
]
```

### show language switcher 

```textmate
Theme View Fallbacks
When you're doing backpack_view('path.to.view'), Backpack will look both the namespace and fallback namespace configured in config/backpack/ui.php. If nothing is found, it will also look in the backpack/ui directory. For example if you have:

    'view_namespace'          => 'admin.theme-custom.',
    'view_namespace_fallback' => 'backpack.theme-tabler::',
Backpack will use the first file it finds, in the order below. If none of these views exist, it will throw an error:

resources/views/admin/theme-custom/path/to/view.blade.php
resources/views/vendor/backpack/theme-tabler/path/to/view.blade.php
vendor/backpack/theme-tabler/resources/views/path/to/view.blade.php
resources/views/vendor/backpack/ui/path/to/view.blade.php
vendor/backpack/crud/src/resources/views/ui/path/to/view.blade.php
This fallback mechanism might look complex at first, but you'll quickly get used to it, and it provides A LOT of power and convenience. It allows you to:

override a blade file for one theme, by placing it in the theme directory;
create a blade file for all themes, by placing it in the ui directory;
easily create new themes, that extends a different theme;
easily add/remove themes from your project, using Composer;
```

So we can put the file `resources/views/vendor/backpack/theme-coreuiv4/inc/topbar_right_content.blade.php`

with content `@include('backpack.language-switcher::language-switcher')`
