# Laravel Clean UI starter

**Laravel UI** provides a very simple authentication starter pack that is a far better starting point for my Laravel
apps
in my opinion. I prefer this over the bloated starter packs like Breeze, or Jetstream.

Laravel Clean.UI is a modification of the Laravel UI, where I removed Bootstrap and replaced it with my Clean.ui CSS
library with some extra JS codes. It is intended for a fullstack Laravel app with the usual blade templates/views, and
Livewire.

It includes a demo blog as an example with posts, post tags, and post categories. However, it will not contain more
example codes to keep this starter slim.

In the project, I try to use good practices when organizing the codes (like the usage of service and repository classes,
use cleaner codes...)

_Disclaimer: This project is under development, not 100% ready._

## Todos

- TODO: Posts and hierarchical category management should be reworked.
- TODO: Add documentation
- TODO: Add the public-facing side of the demo blog, after the admin-side is finalized
- TODO: Add a solution for file upload (mostly image upload). In one live website, I used the laravel-filemanager package, but
  not sure that I will use it here as well. Now, image uploads are not working because laravel-filemanager is removed.
- TODO: Add sample images for seeders to set cover images for posts, and categories. Tags will not have images in the demo.
- TODO: Add a menu point for the /home route to access the Clean UI library with some pre-defined UI components

## Installation

_Only install it for new Laravel projects, because we will overwrite some files (and you may lose your changes you have
already made, e.g. vite.config.js, package.json)!_

1. Install Laravel

2. Install Laravel UI

```shell
composer require laravel/ui
# Generate login / registration scaffolding...
php artisan ui bootstrap --auth
```

3. Copy the `resources` folder over the `resources` folder in your project (overwrite all files)
4. Copy the `public` folder over the `resources` folder in your project (overwrite all files)
5. Overwrite `package.json` and `vite.config` file
6. Add `postcss.config.js` file
7. Add Composer dependencies (see the example config file). Install packages afterwards
8. Install npm packages. Use your Laravel app as usual (npm run dev, php artisan serve)

## Updating laravel/ui

When updating `laravel/ui`, do not run `php artisan ui bootstrap --auth` again, because it will overwrite your custom
auth controllers and views.

## Other configuration

Currently, **mews/purifier** and **tinymce** are not installed and set up for this starter. **TODO!**

- **mews/purifier**
  https://packagist.org/packages/mews/purifier

```bash
php artisan vendor:publish --provider="Mews\Purifier\PurifierServiceProvider"
```

- **tinymce**
  https://www.tiny.cloud/docs/tinymce/6/laravel-tiny-cloud/

## Credits

**Laravel UI**: Copyright (c) Taylor Otwell (MIT license).

## License

**Laravel Clean UI** is a modification / extension for the Laravel UI.

(MIT license).

=================================================

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and
creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in
many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache)
  storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all
modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a
modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video
tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging
into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in
becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in
the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by
the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell
via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
