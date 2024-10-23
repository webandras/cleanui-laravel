# Clean.UI Laravel starter

DO NOT FORK IT! IT IS ONLY A DEMO FOR MY JOB APPLICATIONS! NOT YET PRODUCTION READY EITHER!

Provides a simple starter pack that is a great starting point for my Laravel apps. Use it on your responsibility.

Laravel Clean.UI is Laravel blog starter project that includes the Laravel UI package for authentication with 2fa and
user profile
as additions. It does not use Bootstrap, Tailwind or any other CSS framework. My Clean.UI CSS library, with some extra
JS codes, is used instead,
hence the name of the starter project.
It is intended for a monolithic Laravel app with the usual blade views, and Livewire.

Has a fully-modular structure (outside the `app` folder).
It includes the following modules:

- the **clean module** (_always required_; some general codes)
- the **auth module** (_always required_; provides authentication, 2fa, role-permission based authorization, profile
  and
  preferences management, and user management)
- the **blog module** with posts, post tags, post categories, and a documentation section (_optional_, can be deleted)
- the **job** calendar (_optional_, can be deleted)
- the **events** module (_optional_, can be deleted)

If you want to delete an optional module, make sure to remove its seeders from `DatabaseSeeder.php`. In addition, you
have to remove parts from the blade templates, remove Livewire components (classes and views). Unfortunately, I haven't
found the way to fully modularize the Livewire parts yet.

However, it will not contain more example modules to keep this starter slim.

## News

- This project supports Laravel 11. Livewire was updated to version 3 (with all the necessary changes in components).
  The application structure was not upgraded to the new Laravel 11 structure. As
  stated [in their upgrade guide](https://laravel.com/docs/11.x/upgrade#application-structure),

> However, **we do not recommend** (emphasis mine) that Laravel 10 applications upgrading to Laravel 11 attempt to
> migrate their application structure, as Laravel 11 has been carefully tuned to also support the Laravel 10 application
> structure.

- TODO: Livewire components needs to be modular as the rest of the codebase.
- TODO: Add feature, and e2e tests for the modules in preparation for a release.
- TODO: Improve frontend design

## Screenshot

![Screenshot](screenshot.png "Screenshot of the app")

## Installation

**New projects: Clone the repository or download as zip file.**

And go ahead with the usual steps.

- Install composer packages:

```bash
composer install
```

- Install npm packages:

```bash
npm install
```

Setup `.env` variables. Especially database and email settings. You need to have a local smtp server, and a user
interface to receive and view emails (account verification, 2fa code emails). For example, one solution is to
install [mailcatcher](https://mailcatcher.me/), or [PaperCut SMTP](https://www.papercut-smtp.com/) on your computer.

## Important notes! - Updating laravel/ui

When updating `laravel/ui`, do not run `php artisan ui bootstrap --auth` again, ~~because it will overwrite your custom
auth controllers and views~~ because it is unnecessary, and those reworked auth code parts have already moved to
the `modules` folder, so it won't have any effect anyway.

## Laravel version compatibility (9.x-11.x)

Laravel versions 9.x, 10.x & 11.x (since the starter is based on laravel/ui 4.x) are supported. The starter has Laravel
11.x
support, but versions can be downgraded to Laravel 10.x.

## Third party dependencies & configuration

**mews/purifier**, **tinymce**, and **alexusmai/laravel-file-manager** are installed.

- **mews/purifier**
  https://packagist.org/packages/mews/purifier

```bash
php artisan vendor:publish --provider="Mews\Purifier\PurifierServiceProvider"
```

To enable iframe-embed support for YouTube and Vimeo (can be extended for other video sharing platforms),
copy `_for_htmlpurifier/MyIframe.php` to `vendor/ezyang/htmlpurifier/library/HTMLPurifier/Filter/` folder. This line
should be present in `config/purifier.php` file (which is there by default in this starter):

```php
'Filter.Custom' => array (new HTMLPurifier_Filter_MyIframe()),
```

One disadvantage of this solution is that you can't cache config with this class instantiation present in the file.
Currently, I don't know any workaround to avoid this problem.

If you do not want to have these embeds enabled, remove this line from the config!

- **tinymce**
  https://www.tiny.cloud/docs/tinymce/6/laravel-tiny-cloud/

Copy the tinymce folder from inside `vendor/tinymce` folder to `public/assets`!

- **alexusmai/laravel-file-manager** https://github.com/alexusmai/laravel-file-manager

For file management the `alexusmai/laravel-file-manager` is used here. As an alternative, you can
replace it with `unisharp/laravel-filemanager` or with other packages.
Currently, the posts and the categories use the file manager, tags have a separate image upload implementation.

## License

**Clean.UI Laravel starter**

&copy; András Gulácsi 2023 - MIT license

