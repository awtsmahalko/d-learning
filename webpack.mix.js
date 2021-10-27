const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

// add a prefix subfolder if you upload this app in a 
// subfolder in hosting server 
// 'subfolder/public/js' and 'subfolder/public/js'

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/js', [
        //
    ]).vue();
