$.postJSON = function(url, data, callback) {
	return $.post(url, data, callback, "json");
};