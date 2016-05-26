var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */
elixir.config.sourcemaps = false;
elixir(function (mix) {
    mix
        .sass('app.scss', 'resources/assets/css/app.css')
        .less('bootstrap-tour.less', 'resources/assets/css/bootstrap-tour.css')
        .styles([
            'app.css',
            'bootstrap-tour.css'
        ], 'public/css/app.css')
        .coffee('bootstrap-tour.coffee', 'resources/assets/js/bootstrap-tour.js')
        .scripts([
            'app.js',
            'bootstrap-tour.js'
        ], 'public/js/app.js')
        .version(['css/app.css', 'js/app.js']);
});
