var gulp = require('gulp');
var jshint = require('gulp-jshint');
var concat = require('gulp-concat');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');
var compass = require('gulp-compass');

// Lint JS
gulp.task('lint', function() {
  gulp.src('./js/*.js')
    .pipe(jshint())
    .pipe(jshint.reporter('default'));
});

// Concat & Minify JS
gulp.task('minify', function(){
  // Omit files in js/vendor
  gulp.src(['js/**/*.js', '!js/vendor/**'])
      .pipe(concat('scripts.js'))
      .pipe(gulp.dest('./dist'))
      .pipe(rename('scripts.min.js'))
      .pipe(uglify())
      .pipe(gulp.dest('./dist'));

  // Copy vendor JS files separately
  gulp.src('js/vendor/**')
    .pipe(gulp.dest('./dist/vendor'));        
});


gulp.task('compass', function() {
    gulp.src('./scss/*.scss')
        .pipe(compass({
            config_file: './config.rb'
        }))
        .pipe(gulp.dest('css'));
});

// Default
gulp.task('default', function(){
  gulp.run('minify', 'compass'); //, 'uncss'

  // Watch JS Files
  gulp.watch("./js/*.js", function(event){
    gulp.run('minify');
  });    
  
  // Watch SASS Files
  gulp.watch("./scss/*.scss", function(event){
    gulp.run('compass');
  });  
  
  // Watch CSS Files
  gulp.watch("./css/*.css", function(event){
    //gulp.run('uncss');
  });
});