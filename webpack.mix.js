const mix = require('laravel-mix');

let projectConfig = {};

try {
    projectConfig = require('./project-config.json');
} catch (error) {

}

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

if (mix.inProduction()) {
    mix.version()
        .options({
            // optimize js minification process
            terser: {
                cache: true,
                parallel: true,
                sourceMap: true
            }
        });
} else {
    // Uses inline source-maps
    mix.webpackConfig({
        devtool: 'inline-source-map'
    }).sourceMaps();

    if (projectConfig.proxy) {
        // Uses browserSync
        mix.browserSync(projectConfig.proxy);
    }
}
