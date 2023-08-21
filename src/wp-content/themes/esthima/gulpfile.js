"use strict";

// Load plugins
const autoprefixer = require("autoprefixer");
const browsersync = require("browser-sync").create();
// const cp = require("child_process");
const cssnano = require("cssnano");
const del = require("del");
const eslint = require("gulp-eslint");
const gulp = require("gulp");
// const imagemin = require("gulp-imagemin");
// const newer = require("gulp-newer");
const plumber = require("gulp-plumber");
const postcss = require("gulp-postcss");
const rename = require("gulp-rename");
const less = require("gulp-less");
const webpack = require("webpack");
const webpackconfig = require("./webpack.config.js");
const webpackstream = require("webpack-stream");
const sourcemaps = require('gulp-sourcemaps');
const mqpacker = require('@hail2u/css-mqpacker');


// BrowserSync
function browserSync(done) {
    browsersync.init({
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
  done();
}

// BrowserSync Reload
function browserSyncReload(done) {
  browsersync.reload();
  done();
}

// Clean assets
function clean() {
  return del(["./js/"]);
}

// Optimize Images
// function images() {
//   return gulp
//     .src("./src/images/**/*")
//     .pipe(newer("./images"))
//     .pipe(
//       imagemin([
//         imagemin.gifsicle({ interlaced: true }),
//         imagemin.jpegtran({ progressive: true }),
//         imagemin.optipng({ optimizationLevel: 5 }),
//         imagemin.svgo({
//           plugins: [
//             {
//               removeViewBox: false,
//               collapseGroups: true
//             }
//           ]
//         })
//       ])
//     )
//     .pipe(gulp.dest("./images"));
// }


// CSS task
function css() {
  return gulp
    .src(['./src/less/style.less', './src/less/editor-style.less'], {allowEmpty:true})
	.pipe(plumber())
	.pipe(sourcemaps.init())
    .pipe(less({
      outputStyle: "expanded"
    }))
	.pipe(postcss([autoprefixer(), mqpacker({
			sort: true
		})]))
	.pipe(sourcemaps.write('.'))
    .pipe(gulp.dest("./"))
    .pipe(browsersync.stream());
}

// minify task
function cssprod() {
  return gulp
    .src(['./src/less/style.less', './src/less/editor-style.less'], {allowEmpty:true})
	.pipe(plumber())
    .pipe(less({
      outputStyle: "expanded"
    }))
	.pipe(postcss([autoprefixer(), mqpacker({sort: true}), cssnano()]))
    .pipe(gulp.dest("./"))
}

// Lint scripts
function scriptsLint() {
  return gulp
    .src(["./src/js/**/*"])
    .pipe(plumber())
    .pipe(eslint())
    .pipe(eslint.format())
    .pipe(eslint.failAfterError());
}

// Transpile, concatenate and minify scripts
function scripts() {
  return (
    gulp
      .src(["./src/js/**/*"])
      .pipe(plumber())
      .pipe(webpackstream(webpackconfig, webpack))
      // folder only, filename is specified in webpack config
      .pipe(gulp.dest("./js/"))
      .pipe(browsersync.stream())
  );
}


// Watch files
function watchFiles() {
  gulp.watch("./src/less/**/*", gulp.series(css, browserSyncReload));
  gulp.watch("./src/js/**/*", gulp.series(scripts));
//   gulp.watch(
//     [
//       "./fichier/**/*"
//     ],
//   );
  // gulp.watch("./src/images/**/*", images);
}

// define complex tasks
const js = gulp.series(scripts);
const build = gulp.series(gulp.parallel(cssprod, js));
const watch = gulp.parallel(css, js, watchFiles, browserSync);

// export tasks
// exports.images = images;
exports.clean = clean;
exports.css = css;
exports.js = js;
exports.build = build;
exports.watch = watch;
exports.default = watch;
