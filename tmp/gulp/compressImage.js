"use strict";

var gulp = require('gulp'),
	imagemin = require('gulp-imagemin'),
	path = require('path');

module.exports = function(vinyl) {
	return gulp.src(vinyl.path)
		.pipe(imagemin({
			optimizationLevel: 7,
			progressive : true
		}))
		.pipe(gulp.dest(path.dirname(vinyl.path)));
};