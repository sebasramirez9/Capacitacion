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

mix.styles([
    'resources/assets/templates/css/font-awesome.min.css',
    'resources/assets/templates/css/simple-line-icons.min.css',
    'resources/assets/templates/css/style.css'
], 'public/css/template.css')
    .scripts([
        'resources/assets/templates/js/jquery.min.js',
        'resources/assets/templates/js/popper.min.js',
        'resources/assets/templates/js/bootstrap.min.js',
        'resources/assets/templates/js/Chart.min.js',
        'resources/assets/templates/js/pace.min.js',
        'resources/assets/templates/js/template.js',
    ], 'public/js/template.js')

.js(['resources/assets/js/app.js'],'public/js/app.js');
