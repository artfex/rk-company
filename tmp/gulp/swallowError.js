module.exports = function (error) {
	console.error(error.toString());
	this.emit('end');
};