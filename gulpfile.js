const gulp = require('gulp');
const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');
const notify = require('gulp-notify');
const browserSync = require('browser-sync').create();
const sourcemaps = require('gulp-sourcemaps');
const concat = require('gulp-concat');
const notifier = require('node-notifier');
const exec = require('child_process').exec;
const uglify = require('gulp-uglify');
const del = require('del');

// Define paths
const paths = {
  src: {
    styles: 'src/scss/**/*.scss',
    scripts: 'src/js/**/*',
    images: 'src/img/**/*',
    fonts: 'src/fonts/**/*',
    modules: 'node_modules/html5shiv/dist/html5shiv.min.js',
    site: 'src/site/**/*'
  },
  patterns: {
    styles: 'patterns/assets/css',
    scripts: 'patterns/assets/js',
    images: 'patterns/assets/img',
    fonts: 'patterns/assets/fonts',
    all: 'patterns'
  },
  dist: {
    styles: 'dist/assets/css',
    scripts: 'dist/assets/js',
    images: 'dist/assets/img',
    fonts: 'dist/assets/fonts',
    all: 'dist'
  }
};

// Sass shared config
const scssConfig = function() {
  return sass({
    outputStyle: 'compressed'
  })
  .on('error', sass.logError)
  .on('error', notify.onError(function (error) {
    return {
      title: 'SCSS error',
      message: error.message
    }
  }))
};

const autoprefixerConfig = function() {
  return autoprefixer({
    flexbox: false
  })
};

// Clean patterns folder
gulp.task('cleanPatterns', () => {
  return del([paths.patterns.all]);
});

// Clean website build folder
gulp.task('cleanSite', () => {
  return del(paths.dist.all);
});

// Clean assets build folder
gulp.task('cleanAssets', () => {
  return del('dist/assets');
});

// Copy JavaScript files
gulp.task('jsFiles', () => {
  return gulp.src(paths.src.modules)
    .pipe(gulp.dest('src/site/_includes'));
});

// Copy fonts
gulp.task('fonts', () => {
  return gulp.src(paths.src.fonts)
    .pipe(gulp.dest(paths.dist.fonts));
});

// Images
gulp.task('images', () => {
  return gulp.src(paths.src.images)
    .pipe(gulp.dest(paths.dist.images));
});

// Favicons
gulp.task('favicons', () => {
  return gulp.src('src/img/icons/favicon.*')
    .pipe(gulp.dest(paths.dist.all));
});

// Compile SCSS and autoprefix styles.
gulp.task('styles', () => {
  return gulp.src(paths.src.styles)
    .pipe(sourcemaps.init())
    .pipe(scssConfig())
    .pipe(autoprefixerConfig())
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(paths.dist.styles))
    .pipe(browserSync.stream());
});

// Concatenate and uglify JavaScript
gulp.task('scripts', () => {
  return gulp.src(paths.src.scripts)
    .pipe(concat('production.js'))
    .pipe(uglify())
    .pipe(gulp.dest(paths.dist.scripts));
});

// Build website assets
gulp.task('buildAssets', gulp.parallel(
  'jsFiles',
  'fonts',
  'images',
  'favicons',
  'scripts',
  'styles'
));

gulp.task('generate', function(callback) {
  exec('npx eleventy --quiet', function (err) {
    if (err) {
      notifier.notify({
        title: 'Eleventy Error',
        message: 'Generate Failure'
      })
    }
    callback(err);
  })
});

gulp.task('buildAll', gulp.parallel(
  'buildAssets',
  'generate'
));

gulp.task('serve', () => {
  browserSync.init( {
    server: {
      baseDir: "./dist/",
      serveStaticOptions: {
        extensions: ['html']
      }
    },
    open: false,
    notify: false,
    injectChanges: true
  });
  gulp.watch(paths.src.site, gulp.parallel('generate'));
  gulp.watch(paths.src.styles, gulp.parallel('styles'));
  gulp.watch(paths.src.modules, gulp.parallel('jsFiles'));
  gulp.watch(paths.src.fonts, gulp.parallel('fonts'));
  gulp.watch(paths.src.images, gulp.parallel('images'));
  gulp.watch(paths.src.scripts, gulp.parallel('scripts'));
  gulp.watch(paths.dist.all).on('change', browserSync.reload);
});
