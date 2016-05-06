/**
 * Created by david on 05/05/2016.
 */
var gulp = require("gulp");
gulp.task("dist",function () {
    gulp.src("bower_components/**/*.min.js")
        .pipe(gulp.dest("Resources/public/js/"));
    gulp.src("bower_components/**/*.min.css")
        .pipe(gulp.dest("Resources/public/css/"));
    gulp.src("bower_components/uikit/fonts/*")
        .pipe(gulp.dest("Resources/public/css/uikit/fonts/"));
})