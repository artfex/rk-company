"use strict";

var watch = require('gulp-watch'),
	paths = require('../paths'),
	compressImage = require('../compressImage'),
	tempImages = require('../tempImages'),
	buildCss = require('./build-css'),
	buildJs = require('./build-js');

module.exports = function(){
	watch([paths.watch.css], buildCss);
	watch([paths.watch.js], buildJs);

	watch(paths.watch.images, function (vinyl) {
		if(tempImages.has(vinyl.path)) return;
		tempImages.add(vinyl.path);

		setTimeout(function () {  // timeout need for save file from photoshop
			compressImage(vinyl)
				.on('end', function () {
					setTimeout(function () {
						tempImages.delete(vinyl.path);
					}, 300);
				});
		}, 500);

	});
};