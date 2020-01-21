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

let appVersion = 1;

mix
.js('resources/js/personal/personal.js', 'public/innerWebsite/js/')
    
.js('resources/js/bill_payment_provider/bill_payment_provider.js', 'public/innerWebsite/js/')
    
.js('resources/js/website/website.js', 'public/innerWebsite/js/')
.js('resources/js/bank/bank.js', 'public/innerWebsite/js/')
    //.sass('resources/sass/app.scss', 'public/innerWbsite/css');
