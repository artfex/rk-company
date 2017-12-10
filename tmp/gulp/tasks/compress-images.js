"use strict";

var glob = require('glob-all'),
	path = require('path'),
	paths = require('../paths'),
	compressImage = require('../compressImage');

module.exports = function(){
	glob(paths.watch.images, function(){})
		.on('match', function (filePath) {
			compressImage({
				path : path.normalize(filePath)
			});
		});
};