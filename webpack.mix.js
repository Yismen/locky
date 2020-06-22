const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/vendor/locky/js')
    .sass('resources/sass/app.scss', 'public/vendor/locky/css')
    .copy('public/vendor/locky/js/app.js', '../../public/vendor/dainsys/locky/js')
    .copy('public/vendor/locky/css/app.css', '../../public/vendor/dainsys/locky/css')
    ;
