/**
 * Gulp v4 Configuration
 */

	var environment = 'prod' // always default to production
	var compress = 'compressed' // default to compressed

	if (process.env.NODE_ENV === 'development') {
		environment = 'dev'
		compress = 'expanded' // if development build try to expand
	}
	console.log('gulp settings NODE_ENV:', process.env.NODE_ENV, 'Environment: ' + environment, 'Compress: ' + compress)

	gulp = 			require('gulp'),
	sass = 			require('gulp-sass'),
	globSass = 		require('gulp-sass-glob'),
	autoprefixer = 	require('gulp-autoprefixer'),
	cleanCSS	 = 	require('gulp-clean-css'),
	rename = 		require('gulp-rename'),
	stripDebug = 	require('gulp-strip-debug'),
	jsHint = 		require('gulp-jshint'),
	concat = 		require('gulp-concat'),
	notify = 		require('gulp-notify'),
	plumber = 		require('gulp-plumber'),
    sourcemaps = 	require('gulp-sourcemaps'),
    babel =         require('gulp-babel'),
    terser =        require('gulp-terser'),
    filter =        require('gulp-filter'),

	// used with browser extension
	livereload = 	require('gulp-livereload'),

	// required for svg icons
	svgmin = 		require('gulp-svgmin'),
	svgstore = 		require('gulp-svgstore'),
	gulpif = 		require('gulp-if'),
	cheerio = 		require('gulp-cheerio'),

	// opinionated scss formatting
	prettier = 		require('gulp-prettier'),

	compression = compress;



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
		.pipe(cleanCSS({compatibility: 'ie10'}))
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest('assets/css'))
		.pipe(livereload());
});

gulp.task('styles-login', function() {
	return gulp.src('src/scss/login.scss')
		.pipe(sass({ style: compression }))
		.pipe(autoprefixer('last 2 versions'))
		.pipe(gulp.dest('assets/css'))
		.pipe(notify({ message: "Styles login task complete" }));
});

gulp.task('styles-admin', function() {
	return gulp.src('src/scss/admin.scss')
		.pipe(sass({ style: compression }))
		.pipe(autoprefixer('last 2 versions'))
		.pipe(gulp.dest('assets/css'))
		.pipe(notify({ message: "Styles admin task complete" }));
});

gulp.task('styles-editor', function() {
	return gulp.src('src/scss/editor.scss')
		.pipe(plumber({ errorHandler: onError }))
		.pipe(globSass())
		.pipe(sourcemaps.init())
		.pipe(sass({ style: compression }))
		.pipe(autoprefixer('last 2 versions', '> 1%', 'android > 4'))
		.pipe(cleanCSS())
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest('assets/css'))
		.pipe(notify({ message: "Styles editor task complete" }));
});


/**
 * JAVASCRIPT
 */
gulp.task('scripts', function() {
    const customScripts = filter('src/js/**/*.js' + 'partials/**/*.js' + 'blocks/**/*.js', {restore: true});
	return gulp.src([
		'src/libs/*.js',
		'src/js/theme.js',
		'partials/**/*.js',
		'blocks/**/*.js',
	])
		.pipe(plumber({ errorHandler: onError }))
        .pipe(concat('scripts.js'))
        .pipe(customScripts) // We only want to lint and babelize custom scripts
        .pipe(jsHint())
        .pipe(babel({
            presets: ['@babel/preset-env'],
            ignore: ["./src/libs/svg4everybody.min.js"],
        }))
        .pipe(customScripts.restore)
		.pipe(gulpif('prod'==environment, stripDebug()))
		.pipe(gulpif('prod'==environment, terser()))
		.pipe(gulp.dest('assets/js'))
		.pipe(notify({ message: "Scripts task complete" }));
});


/**
 * ADMIN JS
 *
 * Does not compile partials or theme.js
 */
gulp.task('scripts-admin', function() {
	return gulp.src([
		'src/libs/*.js',
		'blocks/**/*.js',
		'src/js/admin-only.js',
	])
		.pipe(plumber({ errorHandler: onError }))
        .pipe(concat('admin-scripts.js'))
        .pipe(jsHint())
		.pipe(gulp.dest('assets/js'))
		.pipe(notify({ message: "Scripts admin task complete" }));
});


/**
 * SVG ICONS
 *
 * 'gulp icons' (only compiles icons)
 */
gulp.task('icons', function() {
	return gulp.src('src/icons/*')
		//.pipe(gulpif('prod'==environment, svgmin()))
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
		.pipe(notify({message: "Icon SVG updated"}));
});


/**
 * PRETTIER
 *
 * 'gulp prettier'
 */
 gulp.task('pretty-scss', function() {
	return gulp.src('**/*.scss')
		.pipe(plumber({ errorHandler: onError }))
		.pipe(prettier({ singleQuote: true, editorconfig: true }))
		.pipe(gulp.dest(file => file.base))
		//.pipe(notify({ message: "Prettier SCSS task complete" }));
});


/**
 * GULP Task
 *
 * 'gulp'
 */
gulp.task('default', gulp.series('pretty-scss', 'styles', 'styles-login', 'styles-admin', 'styles-editor', 'scripts', 'scripts-admin'));


/**
 * GULP WATCH Task
 *
 * 'gulp watch' (does not compile styles-login, styles-editor or icons)
 */
gulp.task('watch', function() {
	//environment = 'dev'
	livereload({ start: true })

	gulp.watch('src/scss/**/*.scss', gulp.series('styles', 'styles-editor'));
	gulp.watch('partials/**/*.scss', gulp.series('styles'));
	gulp.watch('blocks/**/*.scss', gulp.series('styles'));

	gulp.watch('src/js/**/*.js', gulp.series('scripts'));
	gulp.watch('partials/**/*.js', gulp.series('scripts'));
	gulp.watch('blocks/**/*.js', gulp.series('scripts'));
});


