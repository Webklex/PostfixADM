var gulp = require('gulp');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var pump = require('pump');
var ngAnnotate  = require('gulp-ng-annotate');
var rename      = require('gulp-rename');

var resource_path = "resources/assets/bower/";
var js_path = "resources/assets/js/";
var css_path = "resources/assets/css/";
var tmp_path = "resources/assets/tmp/";

var js_vendors = [
    resource_path + "angular/angular.min.js",
    resource_path + "angular-animate/angular-animate.min.js",
    resource_path + "angular-aria/angular-aria.min.js",
    resource_path + "angular-messages/angular-messages.min.js",
    resource_path + "angular-sanitize/angular-sanitize.min.js",
    resource_path + "angular-local-storage/dist/angular-local-storage.js",
    resource_path + "angular-material/angular-material.min.js"
];

var angular_components = [
    'domain',
    'mailbox',
];

/**
 * Copy any needed files.
 *
 * Do a 'gulp copyfiles' after bower updates
 */
gulp.task("copyfiles", function() {

    gulp.src(resource_path + "angular-material/angular-material.min.css")
        .pipe(gulp.dest("resources/assets/css/vendors"));

});
gulp.task("default", function() {

    gulp.src(js_vendors)
    .pipe(concat('vendors.js'))
    .pipe(rename({
        suffix: ".min"
    }))
    .pipe(gulp.dest('public/assets/js'));

    gulp.src([
        '!' + js_path + 'vendors/*.js',
        '!' + js_path + 'angular/*.js',
        js_path + '*.js'
    ])
    .pipe(concat('app.js'))
    .pipe(uglify())
    .pipe(gulp.dest('public/assets/js'));

    gulp.src([
        css_path + 'vendors/*.css'
    ])
    .pipe(concat('vendors.css'))
    .pipe(gulp.dest('public/assets/css'));

    gulp.src([
        '!' + css_path + 'vendors/*.css',
        css_path + '*.css'
    ])
    .pipe(concat('app.css'))
    .pipe(gulp.dest('public/assets/css'));

    for(var i = 0; i < angular_components.length; i++){
        var name = angular_components[i];
        gulp.src([
            js_path + 'angular/generic/*.js',
            js_path + 'angular/generic/**/*.js',
            js_path + 'angular/'+ name +'/*.js',
            js_path + 'angular/'+ name +'/**/*.js'
        ])
            .pipe(concat(name+ '.js'))
            .pipe(gulp.dest(tmp_path+'/js'))
            .pipe(ngAnnotate())
            .pipe(uglify())
            .pipe(rename({
                suffix: ".min"
            }))
            .pipe(gulp.dest('public/assets/js'));
    }

});