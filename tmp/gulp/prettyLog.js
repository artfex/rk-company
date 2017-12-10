var gulpUtil = require('gulp-util'),
	chalk = require('chalk'),
	prettyHrtime = require('pretty-hrtime');

module.exports = function (task, time) {
	gulpUtil.log(
		'\'' + chalk.cyan(task) + '\'', 'finished',
		time ? 'after ' + chalk.magenta(prettyHrtime(time)) : ''
	);
};