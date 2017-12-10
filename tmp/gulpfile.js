var gulp = require('gulp');

gulp.task('build-css', require('./gulp/tasks/build-css'));
gulp.task('build-js', require('./gulp/tasks/build-js'));
gulp.task('compress-images', require('./gulp/tasks/compress-images'));
gulp.task('watch', require('./gulp/tasks/watch'));