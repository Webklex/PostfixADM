var elixir = require('laravel-elixir');
var elixir_task = elixir.Task;
var gulp = require('gulp');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var minifyCss = require('gulp-minify-css');
var pump = require('pump');
var ngAnnotate  = require('gulp-ng-annotate');
var rename      = require('gulp-rename');
var sass = require('gulp-sass');
var shell = require('gulp-shell');
var gulpFilter  = require('gulp-filter');
var bowerFiles  = require('main-bower-files');
var flatten     = require('gulp-flatten');

var resource_path = "resources/assets/bower/";
var js_path = "resources/assets/js/";
var css_path = "resources/assets/css/";
var scss_path = "resources/assets/sass/";
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


var dir = {
    bower:  'resources/assets/bower',
    dist:   'public'
};

var angular_components = [
    'domain',
    'mailbox',
    'alias',
    'auth',
    'user',
];


elixir.extend('custom_watch', function() {
    gulp.watch('routes/**/*.php', ['php']);
    gulp.watch(js_path + '**/*.js', ['scripts']);
    gulp.watch([css_path + '**/*.css', tmp_path + 'css/*.css'],  ['styles']);
    gulp.watch([scss_path + '*.scss', scss_path + '**/*.scss'],  ['sass']);
});

elixir(function(mix) {
    mix.
    browserSync({
        injectChanges: true,
        proxy: 'postfixadm.dev',
        open: false,
        files: [
            "resources/views/**/*.blade.php",
            "public/**/*.css",
            "public/js/**/*.js"
        ]
    }).custom_watch();
});

gulp.task('default', ['php', 'bower', 'copyfiles', 'scripts', 'styles']);

gulp.task('php', shell.task([
    './artisan update'
]));

/**
 * Copy any needed files.
 *
 * Do a 'gulp copyfiles' after bower updates
 */
gulp.task("copyfiles", function(done) {


});

gulp.task("scripts", function() {
    gulp.src([
        '!' + js_path + 'vendors/*.js',
        '!' + js_path + 'angular/*.js',
        js_path + '*.js'
    ])
        .pipe(concat('app.js'))
        .pipe(uglify())
        .pipe(gulp.dest('public/assets/js'));

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

gulp.task('sass', function(done) {
    gulp.src(['resources/assets/sass/**/*.scss'])
        .pipe(concat('scss.css'))
        .pipe(sass())
        .on('error', sass.logError)
        .pipe(gulp.dest(tmp_path+'css'))
        .on('end', done);
});

gulp.task("styles", function(done) {
    gulp.src([css_path + '**/*.css', tmp_path + 'css/*.css'])
        .pipe(concat('app.css'))
        .pipe(gulp.dest('public/assets/css'))
        .on('end', done);

});

/*Gulp task Bower*/
gulp.task('bower', function() {
    var jsFilter    = gulpFilter('*.js', {restore: true});
    var cssFilter   = gulpFilter('*.css', {restore: true});
    var fontFilter  = gulpFilter(['*.eot', '*.woff', '*.woff2', '*.svg', '*.ttf'], {restore: true});
    var imageFilter = gulpFilter(['*.gif', '*.png', '*.svg', '*.jpg', '*.jpeg'], {restore: true});

    return gulp.src(bowerFiles({
        paths: {
            bowerDirectory: dir.bower,
            bowerrc: '.bowerrc',
            bowerJson: 'bower.json'
        }
    }))

    // JS
    .pipe(jsFilter)
    .pipe(concat('vendors.js'))
    .pipe(uglify())
    .pipe(rename({
        suffix: ".min"
    }))
    .pipe(gulp.dest('public/assets/js'))
    .pipe(jsFilter.restore)

    // CSS
    .pipe(cssFilter)
    .pipe(concat('vendors.css'))
    .pipe(minifyCss({processImport: false}))
    .pipe(rename({
        suffix: ".min"
    }))
    .pipe(gulp.dest('public/assets/css'))
    .pipe(cssFilter.restore)

    // FONTS
    .pipe(fontFilter)
    .pipe(flatten())
    .pipe(gulp.dest('public/assets/fonts'))
    .pipe(fontFilter.restore)

    // IMAGES
    .pipe(imageFilter)
    .pipe(flatten())
    .pipe(gulp.dest('public/assets/images'))
    .pipe(imageFilter.restore)
});