const { mix } = require('laravel-mix');

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

mix.js('resources/assets/main.js', 'public/js');

mix.sass('resources/assets/app.scss', 'public/css').version();

// 	'resources/assets/css/xenon.css',
mix.combine([
		'resources/assets/css/custom.css',
		'resources/assets/css/xenon-components.css',
		'resources/assets/css/xenon-core.css',
		'resources/assets/css/xenon-forms.css',
		'resources/assets/css/xenon-skins.css',
		'node_modules/sweetalert2/dist/sweetalert2.min.css',
	],'public/css/all.css').version();

mix.combine([
		'resources/assets/js/joinable.js',
		'resources/assets/js/resizeable.js',
		'resources/assets/js/TweenMax.min.js',
		'resources/assets/js/TweenLite.min.js',
		'resources/assets/js/xenon-api.js',
		'resources/assets/js/xenon-custom.js',
		'resources/assets/js/xenon-toggles.js'
	],'public/js/all.js').version();

//自定义模块配置
mix.webpackConfig({
    resolve: {
    	alias: {
		  components: path.resolve(__dirname, 'resources/assets/components/'),
		  js: path.resolve(__dirname, 'resources/assets/js/'),
		  css: path.resolve(__dirname, 'resources/assets/css/'),
		},
	    modules: [
            path.resolve(__dirname, 'resources/assets/components/'),
            path.resolve(__dirname, 'resources/assets/js/'),
            path.resolve(__dirname, 'resources/assets/css/'),
            "node_modules"
        ]
    }
});