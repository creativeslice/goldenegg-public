var gulp = require('gulp'),
	sass = require('gulp-sass'),
	autoprefixer = require('gulp-autoprefixer'),
	minifycss = require('gulp-minify-css'),
	uglify = require('gulp-uglify'),
	rename = require('gulp-rename'),
<<<<<<< HEAD
	stripDebug = require('gulp-strip-debug'),
	jsHint = require('gulp-jshint'),
=======
>>>>>>> d6843c5e067ec992d581ec0eb12c83b61471cbfb
	concat = require('gulp-concat'),
	notify = require('gulp-notify'),
	clean = require('gulp-clean'),
	cache = require('gulp-cache');

// CSS
gulp.task('styles', function() {
	return gulp.src('scss/style.scss')
		.pipe(sass({ style: 'expanded' }))
		.pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
		.pipe(gulp.dest('css'))
		.pipe(minifycss())
		.pipe(rename({suffix: '.min'}))
		.pipe(gulp.dest('css'))
		.pipe(notify({ message: 'Styles task complete' }));
});
gulp.task('styles-ie', function() {
	return gulp.src('scss/ie.scss')
		.pipe(sass({ style: 'compressed' }))
		.pipe(autoprefixer('last 2 version', 'ie 7', 'ie 8'))
		.pipe(gulp.dest('css'))
		.pipe(notify({ message: 'IE styles task complete' }));
});
gulp.task('styles-login', function() {
	return gulp.src('scss/login.scss')
		.pipe(sass({ style: 'expanded' }))
		.pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
		.pipe(gulp.dest('css'))
		.pipe(notify({ message: 'Admin styles task complete' }));
});

// JS
gulp.task('scripts', function() {
<<<<<<< HEAD
	return gulp.src(['js/src/*.js'])
=======
	return gulp.src('js/libs/*.js')
>>>>>>> d6843c5e067ec992d581ec0eb12c83b61471cbfb
		.pipe(concat('scripts.js'))
		.pipe(jsHint())
		.pipe(stripDebug())
		.pipe(uglify())
		.pipe(gulp.dest('js'))
		.pipe(notify({ message: 'Scripts task complete' }));
});

// CLEANUP
gulp.task('clean-prod', function() {
	// delete anything that shouldn't be on the server
<<<<<<< HEAD
	return gulp.src(['scss', 'node_modules'], {read: false})
=======
	return gulp.src(['scss', 'node_modules', 'gulpfile.js'], {read: false})
>>>>>>> d6843c5e067ec992d581ec0eb12c83b61471cbfb
	.pipe(clean());
});


// default: gulp
gulp.task('default', function() {
	gulp.start('styles', 'scripts');
});

// production: gulp
	// only run on the production server
gulp.task('prod', function() {
	gulp.start('styles', 'scripts', 'clean-prod');
});


// gulp watch
gulp.task('watch', function() {

	gulp.watch('scss/**/*.scss', ['styles', 'styles-ie', 'styles-login']);

	gulp.watch('js/**/*.js', ['scripts']);
});