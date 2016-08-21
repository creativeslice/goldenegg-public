/**
 * Gulp Configuration
 */

var environment = 'development', // 'production development'
	gulp = require('gulp'),
	sass = require('gulp-sass'),
	autoprefixer = require('gulp-autoprefixer'),
	minifycss = require('gulp-minify-css'),
	uglify = require('gulp-uglify'),
	rename = require('gulp-rename'),
	stripDebug = require('gulp-strip-debug'),
	jsHint = require('gulp-jshint'),
	concat = require('gulp-concat'),
	notify = require('gulp-notify'),
	cache = require('gulp-cache'),
	plumber = require('gulp-plumber'),
	svgmin = require('gulp-svgmin'), // required for svg icons
	svgstore = require('gulp-svgstore'), // required for svg icons
	gulpif = require('gulp-if'), // required for svg icons
	cheerio = require('gulp-cheerio'), // required for svg icons
	livereload = require('gulp-livereload'),
	compression = ( 'production' === environment ? 'compressed' : 'expanded' );

// Default error handler
var onError = function( error ) {
	notify.onError({
		title:    "Gulp",
		subtitle: "Failure!",
		message:  "Error: <%= error.message %>"
	})(error);
	this.emit('end');
}


/**
 * CSS
 */
gulp.task('styles', function() {
	return gulp.src('scss/style.scss')
		.pipe( plumber( { errorHandler: onError } ) )
		.pipe(sass({ style: compression }))
		.pipe(autoprefixer('last 2 versions', 'safari 5', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
		.pipe(gulp.dest('css'))
		.pipe(minifycss())
		.pipe(rename({suffix: '.min'}))
		.pipe(gulp.dest('css'))
		.pipe(livereload())
});
gulp.task('styles-ie', function() {
	return gulp.src('scss/ie.scss')
		.pipe(sass({ style: compression }))
		.pipe(autoprefixer('ie 7', 'ie 8'))
		.pipe(gulp.dest('css'))
		.pipe(notify({ message: 'IE styles task complete' }));
});
gulp.task('styles-login', function() {
	return gulp.src('scss/login.scss')
		.pipe(sass({ style: compression }))
		.pipe(autoprefixer('last 2 versions', 'safari 5', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
		.pipe(gulp.dest('css'))
		.pipe(notify({ message: 'Admin styles task complete' }));
});
gulp.task('styles-editor', function() {
	return gulp.src('scss/editor.scss')
		.pipe(sass({ style: compression }))
		.pipe(autoprefixer('last 2 versions', 'safari 5', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
		.pipe(gulp.dest('css'))
		.pipe(notify({ message: 'Editor styles task complete' }));
});


/**
 * JAVASCRIPT
 */
gulp.task('scripts', function() {
	if ( 'production' === environment ) {
		return gulp.src([
				'js/src/libs/*.js',
				'js/src/**/*.js',
			])
			.pipe(concat('scripts.js'))
			.pipe(jsHint())
			.pipe(stripDebug())
			.pipe(uglify())
			.pipe(gulp.dest('js'))
			.pipe(notify({ message: 'Production scripts task complete' }));
	} else {
		return gulp.src([
				'js/src/libs/*.js',
				'js/src/**/*.js',
			])
			.pipe(concat('scripts.js'))
			.pipe(jsHint())
			.pipe(gulp.dest('js'))
			.pipe(livereload())
			.pipe(notify({ message: 'Scripts task complete' }));
	}
});


/**
 * SVG ICONS
 *
 * compile using 'gulp icons'
 *
 */
gulp.task('icons', function() {
	return gulp.src('icons/src/*')
		.pipe( gulpif('production'==environment, svgmin()) )
		.pipe( svgstore({ inlineSvg: true }) )
		.pipe( cheerio({
			run: function( $, file ) {
				$('svg').addClass('hide');
				$('symbol[id!=logo]').find('path,g,polygon,circle,rect').removeAttr('fill');
			},
			parserOptions: { xmlMode: true },
		}))
		.pipe( rename('icons.svg') )
		.pipe( gulp.dest('icons') )
		.pipe( notify({
			title: 'Images',
			message: 'Icons complete'
		}) );
});


// 'gulp'
gulp.task('default', function() {
	gulp.start('styles', 'styles-ie', 'styles-login', 'styles-editor', 'scripts');
});

// 'gulp watch' (does not compile styles-ie or styles-login or icons)
gulp.task('watch', function() {
	livereload.listen();
	gulp.watch('scss/**/*.scss', ['styles']);
	gulp.watch('js/src/**/*.js', ['scripts']);
});