var gulp = require('gulp'),
	sass = require('gulp-ruby-sass'),
	autoprefixer = require('gulp-autoprefixer'),
	minifycss = require('gulp-minify-css'),
	// jshint = require('gulp-jshint'),
	uglify = require('gulp-uglify'),
	rename = require('gulp-rename'),
	clean = require('gulp-clean'),
	concat = require('gulp-concat'),
	notify = require('gulp-notify');


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
		.pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
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

gulp.task('scripts', function() {
	return gulp.src('js/libs/*.js')
		// .pipe(jshint())
		// .pipe(jshint.reporter('default'))
		.pipe(concat('scripts.js'))
		.pipe(gulp.dest('js'))
		.pipe(rename({suffix: '.min'}))
		.pipe(uglify())
		.pipe(gulp.dest('js'))
		.pipe(notify({ message: 'Scripts task complete' }));
});


gulp.task('clean', function() {
	// CLEANUP ANYTHING THAT IS NOT NEEDED FOR PRODUCTION
	return gulp.src(['css/assets', 'js/assets', 'img/assets'], {read: false})
	.pipe(clean());
});


gulp.task('default', function() {
	gulp.start('styles', 'scripts');
});


gulp.task('watch', function() {

	// liveReload
	//server.listen(35729, function (err) {
	//	if (err) {
	//		return console.log(err)
	//	};
		//// Watch tasks go inside inside server.listen()

		gulp.watch('scss/**/*.scss', ['styles', 'styles-ie', 'styles-login']);

		gulp.watch('js/**/*.js', ['scripts']);

		//gulp.watch('img/**/*', ['images']);
	//});
});