/**
 * Gulp Configuration
 */

var environment = 'development', // 'production' or 'development'

	gulp = 			require('gulp'),
	sass = 			require('gulp-sass'),
	globSass = 		require('gulp-sass-glob'),
	autoprefixer = 	require('gulp-autoprefixer'),
	minifycss = 	require('gulp-minify-css'),
	uglify = 		require('gulp-uglify'),
	rename = 		require('gulp-rename'),
	stripDebug = 	require('gulp-strip-debug'),
	jsHint = 		require('gulp-jshint'),
	concat = 		require('gulp-concat'),
	notify = 		require('gulp-notify'),
	cache = 		require('gulp-cache'),
	plumber = 		require('gulp-plumber'),
	sourcemaps = 	require('gulp-sourcemaps'),
	
	// used with browser extension
	livereload = 	require('gulp-livereload'),
	
	// required for svg icons
	svgmin = 		require('gulp-svgmin'),
	svgstore = 		require('gulp-svgstore'),
	gulpif = 		require('gulp-if'),
	cheerio = 		require('gulp-cheerio'),
	
	compression = ( 'production' === environment ? 'compressed' : 'expanded' );


/**
 * Error handler
 */
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
	return gulp.src('src/scss/style.scss')
		.pipe(plumber({ errorHandler: onError }))
		.pipe(globSass())
		.pipe(sourcemaps.init())
		.pipe(sass({ style: compression }))
		.pipe(autoprefixer('last 2 versions', '> 1%', 'android > 4'))
		.pipe(minifycss())
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest('assets/css'))
		.pipe(livereload());
});

gulp.task('styles-login', function() {
	return gulp.src('src/scss/login.scss')
		.pipe(sass({ style: compression }))
		.pipe(autoprefixer('last 2 versions'))
		.pipe(gulp.dest('assets/css'))
		.pipe(notify({ message: 'Admin styles task complete' }));
});

gulp.task('styles-editor', function() {
	return gulp.src('src/scss/editor.scss')
		.pipe(sass({ style: compression }))
		.pipe(autoprefixer('last 2 versions'))
		.pipe(gulp.dest('assets/css'))
		.pipe(notify({ message: 'Editor styles task complete' }));
});


/**
 * JAVASCRIPT
 */
gulp.task('scripts', function() {
	return gulp.src([
			'src/libs/**/*.js',
			'src/js/**/*.js',
			'components/**/*.js',
		])
		.pipe(concat('scripts.js'))
		.pipe(jsHint())
		.pipe(gulpif('production'==environment, stripDebug()))
		.pipe(gulpif('production'==environment, uglify()))
		.pipe(gulp.dest('assets/js'))
		.pipe(notify({ message: 'Scripts task complete' }));
});


/**
 * SVG ICONS
 *
 * 'gulp icons' (only compiles icons)
 *
 */
gulp.task('icons', function() {
	return gulp.src('src/icons/*')
		.pipe(gulpif('production'==environment, svgmin()))
		.pipe(svgstore({ inlineSvg: true }))
		.pipe(cheerio({
			run: function( $, file ) {
				$('svg').addClass('hide');
				$('symbol[id!=logo]').find('path,g,polygon,circle,rect').removeAttr('fill');
			},
			parserOptions: { xmlMode: true },
		}))
		.pipe(rename('icons.svg'))
		.pipe(gulp.dest('assets/icons'))
		.pipe(notify({
			title: 'Images',
			message: 'Icons complete'
		}));
});


/**
 * GULP Task
 *
 * 'gulp' (does not compile icons)
 *
 */
gulp.task('default', function() {
	gulp.start('styles', 'styles-login', 'styles-editor', 'scripts');
});


/**
 * GULP WATCH Task
 *
 * 'gulp watch' (does not compile styles-login, styles-editor or icons)
 *
 */
gulp.task('watch', function() {
	livereload.listen();
	gulp.watch('src/scss/**/*.scss', ['styles']);
	gulp.watch('components/**/*.scss', ['styles']);
	gulp.watch('src/js/**/*.js', ['scripts']);
	gulp.watch('components/**/*.js', ['scripts']);
});
