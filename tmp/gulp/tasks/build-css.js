var gulp = require('gulp'),
	sass = require('gulp-sass'),
	sourcemaps = require('gulp-sourcemaps'),
	autoprefixer = require('gulp-autoprefixer'),
	paths = require('../paths'),
	swallowError = require('../swallowError'),
	prettyLog = require('../prettyLog');

module.exports = function () {
	var time = process.hrtime();
	return gulp.src(paths.css.mainFile)
		.pipe(sourcemaps.init())
		.pipe(sass({outputStyle: 'expanded'}))
		.on('error', swallowError)
		.pipe(autoprefixer({ map: false }))
		.pipe(sourcemaps.write('./'))
		.pipe(gulp.dest(paths.css.bundlePath))
		.on('end', function () {
			prettyLog('build-css', process.hrtime(time));
		});
};