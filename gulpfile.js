const {src, dest, watch, parallel} = require('gulp');

// CSS
const sass = require('gulp-sass')(require('sass'));
const plumber = require('gulp-plumber');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const postcss = require('gulp-postcss');
const sourcemaps = require('gulp-sourcemaps');

// Images
const cache = require('gulp-cache');
const imagemin = require('gulp-imagemin');
const webp = require('gulp-webp');
const avif = require('gulp-avif');

// Javascript
const terser = require('gulp-terser-js');
const concat = require('gulp-concat');
const rename = require('gulp-rename');

// Webpack
const webpack = require("webpack-stream");

const paths = {
    scss: 'src/scss/**/*.scss',
    js: 'src/js/**/*.js',
    images: 'src/img/**/*'
}

function css() {
    return src(paths.scss)
        .pipe(sourcemaps.init())
        .pipe(sass({outputStyle: 'expanded'}))
        .pipe(postcss([autoprefixer()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('public/build/css'));
}

function javascript() {
    return src(paths.js)
        .pipe(webpack({
            module: {
                rules: [
                    {
                        test: /\.css$/i,
                        use: ["style-loader", "css-loader"]
                    }
                ]
            },
            mode: "production",
            watch: true,
            entry: "./src/js/app.js"
        }))
        .pipe(sourcemaps.init())
        // .pipe(concat('bundle.js')) 
        .pipe(terser())
        .pipe(sourcemaps.write('.'))
        .pipe(rename({ suffix: '.min'}))
        .pipe(dest('./public/build/js'))
}

function images() {
    return src(paths.images)
        .pipe(cache(imagemin({ optimizationLevel: 3})))
        .pipe(dest('public/build/img'))
}

function webpVersion(done) {
    src('src/img/**/*.{png,jpg}')
        .pipe(webp())
        .pipe(dest('public/build/img'))
    done();
}

function avifVersion(done) {
    src('src/img/**/*.{png,jpg}')
        .pipe(avif())
        .pipe(dest('public/build/img'))
    done();
}

function dev(done) {
    watch(paths.scss, css);
    watch(paths.js, javascript);
    watch(paths.images, images);
    watch(paths.images, webpVersion);
    watch(paths.images, avifVersion);
    done();
}

exports.css = css;
exports.js = javascript;
exports.images = images;
exports.webpVersion = webpVersion;
exports.avifVersion = avifVersion;
exports.default = parallel( css, images, webpVersion, avifVersion, javascript, dev) ;