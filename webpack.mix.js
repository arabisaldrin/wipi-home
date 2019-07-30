const mix = require('laravel-mix');
const path = require('path');
const VueAutoRoutingPlugin = require('vue-auto-routing/lib/webpack-plugin');
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

mix.disableNotifications();

mix.webpackConfig({
	resolve: {
		alias: {
			'@': path.resolve(__dirname, 'resources')
		}
	},
	plugins: [
		new VueAutoRoutingPlugin({
			// Path to the directory that contains your page components.
			pages: 'resources/pages',

			// A string that will be added to importing component path (default @/pages/).
			importPrefix: '@/pages/'
		})
	],
	output: {
		filename: '[name].js',
		chunkFilename: 'js/chunks/[name].js'
	},
	devtool: 'source-map'
});

mix.js('resources/js/app.js', 'public/js').sass('resources/assets/style/app.scss', 'public/css');
