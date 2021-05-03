const mix = require('laravel-mix');

mix.browserSync({
	proxy: 'localhost/daydream',
	files: [
		'**/*.php',
		'dist/css/**/*.css',
		'dist/js/**/*.js'
	],
	injectChanges: true,
	open: false
});

mix.js('src/js/marie-wp-plugin-starter.js', 'dist/js')
.sass('src/scss/marie-wp-plugin-starter.scss', 'dist/css')