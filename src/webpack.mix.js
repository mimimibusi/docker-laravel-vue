// /*
//  |--------------------------------------------------------------------------
//  | Mix Asset Management
//  |--------------------------------------------------------------------------
//  |
//  | Mix provides a clean, fluent API for defining some Webpack build steps
//  | for your Laravel application. By default, we are compiling the Sass
//  | file for the application as well as bundling up all the JS files.
//  |
//  */

const mix = require("laravel-mix");
mix.ts("resources/js/app.js", "public/js") //app.tsだとここがanyとかでエラー
    .sass("resources/sass/app.scss", "public/css")
    .vue();