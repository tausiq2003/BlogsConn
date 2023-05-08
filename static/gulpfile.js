const gulp = require('gulp');
var sass = require('gulp-sass')(require('sass'));

// Task 1: Converting SASS to CSS
gulp.task('sass', async function(){
    return gulp.src('scss/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('css/'));
});

// Task 2: Watch task
gulp.task("watch", async function(){
    gulp.watch('scss/*.scss', gulp.series('sass'));
});

