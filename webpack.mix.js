const mix = require('laravel-mix');

mix.browserSync({
	proxy: 'localhost/twenty-one',
	files: [
		'**/*.php',
		'dist/css/**/*.css',
		'dist/js/**/*.js'
	],
	injectChanges: true,
	open: false
});

mix.js('src/js/easy-resources-page.js', 'dist/js')
.js('src/js/easy-resources-page-admin.js', 'dist/js')
.sass('src/scss/easy-resources-page.scss', 'dist/css')