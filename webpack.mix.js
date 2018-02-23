let mix = require('laravel-mix');

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

mix.webpackConfig({
    node: {
	  child_process: 'empty',
	  fs: 'empty'
	}
}).js([
	'resources/assets/js/lib/pusher.min.js',
	'resources/assets/js/app.js',
	'resources/assets/js/lib/material.min.js',
	'resources/assets/js/lib/perfect-scrollbar.jquery.min.js',
	'resources/assets/js/lib/jquery.validate.min.js',
	'resources/assets/js/lib/arrive.min.js',
	'resources/assets/js/lib/sweetalert2.js',
	'resources/assets/js/lib/material-dashboard.js'
], 'public/js/app.js')
   .sass('resources/assets/sass/app.scss', 'public/css');
