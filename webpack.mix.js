const mix = require('laravel-mix');
const path = require('path')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
require('laravel-mix-tailwind')

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .postCss('resources/css/app.css', 'public/css')
    .tailwind()
    .alias({
        '@': path.join(__dirname, 'resources/assets')
    });

mix.webpackConfig({
    output: {
        chunkFilename: "js/[name].js?id=[chunkhash]",
    },
    module: {
        rules: [
            {
                test: /\.(postcss)$/,
                use: [
                    'vue-style-loader',
                    {
                        loader: 'css-loader',
                        options: {
                            importLoaders: 1
                        }
                    },
                    'postcss-loader'
                ]
            }
        ]
    }
});
