
/*
 |----------------------------------------------------------------------------
 | Gulp Asset Management
 |----------------------------------------------------------------------------
 |
 | This gulp file is designed to make the process of "compiling code on the
 | fly" and requires a config file called: gulp.env
 |
 | Please be aware that this config file requires at least all the config
 | parameters which are defined within the gulp.env.example file.
 |
 */
var elixir      = require('laravel-elixir');
var gulp        = require('gulp');
var concat      = require('gulp-concat');
var uglify      = require('gulp-uglify');
var minifyCss   = require('gulp-minify-css');
var pump        = require('pump');
var ngAnnotate  = require('gulp-ng-annotate');
var rename      = require('gulp-rename');
var sass        = require('gulp-sass');
var shell       = require('gulp-shell');
var gulpFilter  = require('gulp-filter');
var bowerFiles  = require('main-bower-files');
var flatten     = require('gulp-flatten');
var fs 			= require('fs');
var dotenv 		= require('dotenv');

var config      = dotenv.parse(fs.readFileSync('gulp.env'));

var js_path = "resources/assets/js/";
var css_path = "resources/assets/css/";
var scss_path = "resources/assets/sass/";
var tmp_path = "resources/assets/tmp/";



/*
 |----------------------------------------------------------------------------
 | Directory configuration
 |----------------------------------------------------------------------------
 |
 | All the different code types have their own directory config, so if however
 | you need to add an other folder, feel free to add it to the array.
 |
 */
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
    'installer',
    'updater',
];



/*
 |----------------------------------------------------------------------------
 | Elixir Asset Management
 |----------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 | However in this case it is primary used for bringing browser sync up.
 | BrowserSync only monitors two directories within the webroot (js and css).
 |
 */
elixir.extend('custom_watch', function() {
    gulp.watch('routes/**/*.php', ['php']);
    gulp.watch(js_path + '**/*.js', ['scripts']);
    gulp.watch([css_path + '**/*.css', tmp_path + 'css/*.css'],  ['styles']);
    gulp.watch([scss_path + '*.scss', scss_path + '**/*.scss'],  ['sass']);
});

elixir(function(mix) {
    mix
    .custom_watch()
    .browserSync({
        injectChanges: true,
        proxy: config.APP_URL,
        open: false,
        files: [
            "public/**/*.css",
            "public/js/**/*.js",
            "routes/**/*.php",
            "app/Http/Controllers/**/*.php",
            "resources/views/**/*.php",
            "!resources/views/email/**/*.php"
        ]
    })
});



/*
 |----------------------------------------------------------------------------
 | Default gulp task
 |----------------------------------------------------------------------------
 |
 | The default gulp call is triggered by just calling 'gulp' in your console.
 | By default the following tasks will be executed: bower, sass, scripts,
 | styles and inject.
 |
 */
gulp.task('default', ['php', 'bower', 'scripts', 'styles']);



/*
 |----------------------------------------------------------------------------
 | PHP gulp task
 |----------------------------------------------------------------------------
 |
 | This task is used to call the magic artisan update command ;)
 |
 */
gulp.task('php', shell.task([
    './artisan route:clear'
]));



/*
 |----------------------------------------------------------------------------
 | Scripts gulp task
 |----------------------------------------------------------------------------
 |
 | This task is used to compile all given .js files within the previously
 | defined js folders. Take a look at dir.js for more information on
 | which folders are included.
 |
 | The result is stored inside the public js folder and will be injected
 | later by 'inject' inside the blade template.
 |
 | The angular components should be sorted automatically by ngAnnotate. For
 | more information visit: https://www.npmjs.com/package/gulp-ng-annotate
 | for more information.
 |
 */
gulp.task("scripts", function(done) {

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


    gulp.src([
        js_path + 'angular/generic/**/*.js'
    ])
        .pipe(concat('generic.js'))
        .pipe(gulp.dest(tmp_path+'/js'))
        .pipe(ngAnnotate())
        .pipe(uglify())
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
        .pipe(gulp.dest('public/assets/js'))
        .on('end', done);
});



/*
 |----------------------------------------------------------------------------
 | SASS / SCSS gulp task
 |----------------------------------------------------------------------------
 |
 | This task is used to compile all given .scss files within the previously
 | defined scss folders. Take a look at dir.sass for more information on
 | which folders are included.
 |
 | The result is stored inside the 'tmp' folder and will be compiled again
 | by another gulp task 'styles'.
 |
 */
gulp.task('sass', function(done) {
    gulp.src(['resources/assets/sass/**/*.scss'])
        .pipe(concat('scss.css'))
        .pipe(sass())
        .on('error', sass.logError)
        .pipe(gulp.dest(tmp_path+'css'))
        .on('end', done);
});



/*
 |----------------------------------------------------------------------------
 | Styles gulp task
 |----------------------------------------------------------------------------
 |
 | This task is used to compile all given .css files within the previously
 | defined css folders. Take a look at dir.css for more information on
 | which folders are included.
 |
 | The result is stored inside the public css folder and will be injected
 | later by 'inject' inside the blade template.
 |
 */
gulp.task("styles", function(done) {
    gulp.src([css_path + '**/*.css', tmp_path + 'css/*.css'])
        .pipe(concat('app.css'))
        .pipe(gulp.dest('public/assets/css'))
        .on('end', done);

});

/*
 |----------------------------------------------------------------------------
 | Gulp task bower
 |----------------------------------------------------------------------------
 |
 | This task is used to compile all required and installed bower components.
 | If however a library isn't working or causing errors, consider using an
 | override inside the bower.json file.
 |
 | The output of this will produce potentially 4 folders:
 | public/images/* 			  - All image files that might be placed within the Libraries folders
 | public/fonts/*  			  - All font files that might be placed within the Libraries folders
 | public/js/vendors.min.js   - All java script files that might be placed within the Libraries folders
 | public/css/vendors.min.css - All css files that might be placed within the Libraries folders
 |
 */
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