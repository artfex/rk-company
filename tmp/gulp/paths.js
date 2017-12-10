var path = require('path'),
	homePath = path.join(__dirname, '..'),
	pathToTemplate = path.join(homePath, 'public_html');

module.exports = {
	home : homePath,
	template : pathToTemplate,
	js : {
		mainFile : path.join(homePath, 'src/js/main.js'),
		bundlePath : path.join(pathToTemplate, '/js')
	},
	css : {
		mainFile : path.join(homePath, 'src/scss/global.scss'),
		bundlePath : path.join(pathToTemplate, '/css')
	},
	watch : {
		css : path.join(homePath, 'src/scss/**/*.scss'),
		js : path.join(homePath, 'src/js/**/*.js'),
		bundle : [
			path.join(pathToTemplate, '/css/bundle.css'),
			path.join(pathToTemplate, '/css/bundle.css.map'),
			path.join(pathToTemplate, '/css/global.css'),
			path.join(pathToTemplate, '/css/global.css.map'),
			path.join(pathToTemplate, '/js/bundle.js'),
			path.join(pathToTemplate, '/js/bundle.js.map')
		],
		images : [
			path.join(pathToTemplate, '/(images|i)/**/*.+(png|jpg|svg|gif)'),
			path.join(homePath, '/src/images/**/*.+(png|jpg|svg|gif)')
		]

	}
};