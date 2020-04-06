/**
 * Gulp v4 Configuration
 */

var environment = 'dev', // 'prod' or 'dev'

	gulp = 			require('gulp'),
	sass = 			require('gulp-sass'),
	globSass = 		require('gulp-sass-glob'),
	autoprefixer = 	require('gulp-autoprefixer'),
	cleanCSS	 = 	require('gulp-clean-css'),
	uglify = 		require('gulp-uglify'),
	rename = 		require('gulp-rename'),
	stripDebug = 	require('gulp-strip-debug'),
	jsHint = 		require('gulp-jshint'),
	concat = 		require('gulp-concat'),
	notify = 		require('gulp-notify'),
	plumber = 		require('gulp-plumber'),
	sourcemaps = 	require('gulp-sourcemaps'),

	// used with browser extension
	livereload = 	require('gulp-livereload'),

	// required for svg icons
	svgmin = 		require('gulp-svgmin'),
	svgstore = 		require('gulp-svgstore'),
	gulpif = 		require('gulp-if'),
	cheerio = 		require('gulp-cheerio'),

	compression = ( 'prod' === environment ? 'compressed' : 'expanded' );


	
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
		.pipe(cleanCSS({compatibility: 'ie8'}))
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest('assets/css'))
		.pipe(livereload());
});

gulp.task('styles-login', function() {
	return gulp.src('src/scss/login.scss')
		.pipe(sass({ style: compression }))
		.pipe(autoprefixer('last 2 versions'))
		.pipe(gulp.dest('assets/css'))
		.pipe(notify({ message: "Admin styles task complete" }));
});

gulp.task('styles-editor', function() {
	return gulp.src('src/scss/editor.scss')
		.pipe(sass({ style: compression }))
		.pipe(autoprefixer('last 2 versions'))
		.pipe(gulp.dest('assets/css'))
		.pipe(notify({ message: "Editor styles task complete" }));
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
        .pipe(plumber({ errorHandler: onError }))
        .pipe(concat('scripts.js'))
        .pipe(jsHint())
        .pipe(gulpif('prod'==environment, stripDebug()))
        .pipe(gulpif('prod'==environment, uglify()))
        .pipe(gulp.dest('assets/js'))
        .pipe(notify({ message: "Scripts task complete" }));
});


/**
 * SVG ICONS
 *
 * 'gulp icons' (only compiles icons)
 */
gulp.task('icons', function() {
	return gulp.src('src/icons/*')
		.pipe(gulpif('prod'==environment, svgmin()))
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
			title: "Images",
			message: "Icons complete"
		}));
});


/**
 * GULP Task
 *
 * 'gulp' (does not compile icons)
 */
gulp.task('default', gulp.series('styles', 'styles-login', 'styles-editor', 'scripts'));


/**
 * GULP WATCH Task
 *
 * 'gulp watch' (does not compile styles-login, styles-editor or icons)
 */
gulp.task('watch', function() {
	livereload({ start: true })
	gulp.watch('src/scss/**/*.scss', gulp.series('styles'));
	gulp.watch('components/**/*.scss', gulp.series('styles'));
	gulp.watch('src/js/**/*.js', gulp.series('scripts'));
	gulp.watch('components/**/*.js', gulp.series('scripts'));
});
