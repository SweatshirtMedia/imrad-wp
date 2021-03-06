// Gulp Dependencies

var gulp = require('gulp'),
    gutil = require('gulp-util'),
    sass = require('gulp-sass'),
    connect = require('gulp-connect'),
    uglify = require('gulp-uglify'),
    concat = require('gulp-concat'),
    rename = require('gulp-rename'),
    header = require('gulp-header'),
    sourcemaps = require('gulp-sourcemaps'),
    package = require('./package.json'),
    zip = require('gulp-zip'),
    autoprefixer = require('gulp-autoprefixer'),
    browserSync = require('browser-sync').create(),
    bump = require('gulp-bump'),
    git = require('gulp-git');





// Env Vars

var browserSyncProxy = "imrad.local";


var sassFiles = ["assets/scss/style.scss"];
var sassDest = "./";

var jsFiles = ['assets/js/vendor/*.js', 'assets/js/animations/*.js', 'assets/js/*.js'];
var jsDest = "./"

var watchSassFiles = ['assets/scss/**/*.scss'];
var watchJsFiles = ['assets/js/**/*.js'];
var watchPhpFiles = ['**/*.php'];

var banner = {
    full: '/*!\n' +
        ' * <%= package.name %> v<%= package.version %>: <%= package.description %>\n' +
        ' * (c) ' + new Date().getFullYear() + ' <%= package.author.name %>\n' +
        ' * MIT License\n' +
        ' * <%= package.repository.url %>\n' +
        ' * Open Source Credits: <%= package.openSource.credits %>\n' +
        ' */\n\n',
    min: '/*!' +
        ' <%= package.name %> v<%= package.version %>' +
        ' | (c) ' + new Date().getFullYear() + ' <%= package.author.name %>' +
        ' | <%= package.license %> License' +
        ' | <%= package.repository.url %>' +
        ' | Open Source Credits: <%= package.openSource.credits %>' +
        ' */\n',
    theme: '/*!\n' +
        ' * Theme Name: <%= package.name %>\n' +
        ' * Theme URI: <%= package.repository.url %>\n' +
        ' * GitHub Theme URI: <%= package.repository.url %>\n' +
        ' * Description: <%= package.description %>\n' +
        ' * Version: <%= package.version %>\n' +
        ' * Author: <%= package.author.name %>\n' +
        ' * Author URI: <%= package.author.url %>\n' +
        ' * License: <%= package.license %>\n' +
        ' * ' +
        ' */'
};





gulp.task('sass', gulp.series(function(done) {
    gulp.src(sassFiles)
        .pipe(sourcemaps.init())
        .pipe(sass({ sourceComments: 'map' }))
        .on('error', gutil.log)
        .pipe(header(banner.theme, { package: package }))
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(sourcemaps.write(sassDest))
        .pipe(gulp.dest(sassDest))
        .pipe(browserSync.stream());
    done();
}));




gulp.task('js', gulp.series(function() {
    return gulp.src(jsFiles)
        .pipe(sourcemaps.init())
        .pipe(concat('theme.js'))
        // .pipe(uglify())
        .pipe(sourcemaps.write(jsDest))

        .pipe(gulp.dest(jsDest));
}));





gulp.task('watch', gulp.series(function() {
    gulp.watch(watchSassFiles, gulp.series('sass'));
    gulp.watch(watchJsFiles, gulp.series('js'));


}));







gulp.task('serve', gulp.parallel(function() {

    browserSync.init({
        proxy: browserSyncProxy
    });
}, function() {

    gulp.watch(watchSassFiles, gulp.series('sass'));

    gulp.watch(watchJsFiles, gulp.series('js'));

    gulp.watch(watchPhpFiles).on('change', browserSync.reload);

    gulp.watch("theme.js").on('change', browserSync.reload);
}));

gulp.task('default', gulp.series('sass', 'serve'));