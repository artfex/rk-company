function TempImages() {
	this.elements = {};
}

TempImages.prototype.has = function (key) {
	return key in this.elements;
};
TempImages.prototype.add = function (key) {
	this.elements[key] = true;
	return key;
};
TempImages.prototype.delete = function (key) {
	delete this.elements[key];
	return key;
};

module.exports = new TempImages();