var gulp = require('gulp'),
    gulpLoadPlugins = require('gulp-load-plugins'),
    plugins = gulpLoadPlugins();

gulp.task('watch', function () {
   gulp.watch('js/**/*.js', ['build']);
});

gulp.task('build', ['css', 'js']);

gulp.task('js', function () {
   return gulp.src(['js/**/*.js', '!js/**/*.min.js'])
      .pipe(plugins.jshint())
      .pipe(plugins.jshint.reporter('default'))
      .pipe(plugins.uglify())
      .pipe(plugins.concat('app.js'))
      .pipe(gulp.dest('build'));
});

gulp.task('css', function () {

});