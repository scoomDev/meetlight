const gulp = require('gulp'),
    sass = require('gulp-ruby-sass'),
    cleanCSS = require('gulp-clean-css'),
    autoprefixer = require('gulp-autoprefixer'),
    rename = require('gulp-rename');

gulp.task('sass', () =>
    sass('tw_bootstrap/scss/bootstrap.scss')
        .on('error', sass.logError)
        .pipe(gulp.dest('app/Resources/css'))
);

gulp.task('minify-css', ['autoprefixer'], () =>
    gulp.src('app/Resources/css/*.css')
        .pipe(cleanCSS())
        .pipe(rename('bootstrap.min.css'))
        .pipe(gulp.dest('web/css'))
);

gulp.task('autoprefixer', ['sass'], () =>
    gulp.src('app/Ressources/css/*.css')
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(gulp.dest('app/Ressources/css/*.css'))
);

gulp.task('default', ['minify-css']);