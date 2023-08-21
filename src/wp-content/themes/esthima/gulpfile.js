// Requis
const gulp = require('gulp');
const browserSync = require('browser-sync').create();
const watch = require('gulp-watch');
const plugins = require('gulp-load-plugins')(); // tous les plugins de package.json commençants par "gulp-"


// Tâche "browser-sync"
gulp.task('browser-sync', function() {
	browserSync.init({
		proxy: {
			target: 'localhost'
		},
		ghostMode: {
			clicks: false,
			forms: false,
			scroll: true
		},
		port:8080,
		notify: false,
		open: 'local'
	});
});


// Tâche "css" = LESS + postcss (source -> destination)
gulp.task('css', function() {
	return gulp.src(['./src/less/style.less', './src/less/editor-style.less'])
		.pipe(plugins.plumber())
		.pipe(plugins.sourcemaps.init())
		.pipe(plugins.less())
		.pipe(plugins.postcss())
		.pipe(plugins.sourcemaps.write('.'))
		.pipe(gulp.dest('./'));
});

// Tâche "minify" = minification CSS (source -> destination)
gulp.task('minify', function() {
	return gulp.src(['./*.css', '!./*.min.css'])
		.pipe(plugins.postcss([require('cssnano')]))
		.pipe(gulp.dest('./'));
});


// Tâche "dev"
gulp.task('dev', plugins.sequence(['css'], 'browser-sync'));

// Tâche "prod" = dev + minify
gulp.task('prod', plugins.sequence(['css'], 'minify'));

// Tâche par défaut
gulp.task('default', ['dev'], function() {
	watch([
		'./src/less/**/*.css',
		'./src/less/**/*.less',
		'./src/less/*.less'
	],
	function() {
		gulp.start.apply(gulp, ['css']);
	});

	watch([
		'./*',
		'./**/*',
		'!./src',
		'!./src/*'
	],
	function() {
		browserSync.reload();
	});
});
