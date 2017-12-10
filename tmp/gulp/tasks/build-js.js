var gulp = require('gulp'),
	sourcemaps = require('gulp-sourcemaps'),
	browserify = require('browserify'),
	source = require('vinyl-source-stream'),
	buffer = require('vinyl-buffer'),
	uglify = require('gulp-uglify'),
	paths = require('../paths'),
	swallowError = require('../swallowError'),
	prettyLog = require('../prettyLog');


module.exports = function() {
	var time = process.hrtime();

	var bundler = browserify({
		entries: [paths.js.mainFile],
		debug: true
	});

	var bundle = function() {
		return bundler
			.bundle()
			.on('error', swallowError)
			.pipe(source('bundle.js'))
			.pipe(buffer())
			.pipe(sourcemaps.init({loadMaps: true}))
			.pipe(uglify({compress : false}))
			.pipe(sourcemaps.write('./'))
			.pipe(gulp.dest(paths.js.bundlePath))
			.on('end', function () {
				prettyLog('build-js', process.hrtime(time));
			});
	};

	return bundle();
};