const mix = require('laravel-mix');
require('dotenv').config();

mix.js('resources/js/app.js', 'public/js').
    js('resources/js/admin.js', 'public/js').
    sass('resources/sass/app.scss', 'public/css').
    version();

mix.webpackConfig({
  resolve: {
    alias: {
      ziggy: path.resolve('vendor/tightenco/ziggy/dist/js/route.js'),
    },
  },
});

mix.babelConfig({
  plugins: ['@babel/plugin-syntax-dynamic-import'],
});
