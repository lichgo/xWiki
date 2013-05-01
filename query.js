var http = require('http'),
	querystring = require('querystring'),
	urlParser = require('url').parse,
	paths = [
		'/sedna/query.php',
		'/sedna/query4.php'
		// '/sedna/query7.php',
		// '/sedna/query10.php'
	],
	opts = [];

//init all opts
for (var i = 0, len = paths.length; i < len; i++) {
	opts.push({
		host: '158.132.204.135',
		port: 80,
		path: paths[i],
		method: 'POST',
		headers: {
			'Content-Type': 'application/x-www-form-urlencoded'
		}
	});
}

var server = http.createServer(function(sReq, sRes) {
	var parsedUrl = urlParser(sReq.url, true);
	if (parsedUrl && parsedUrl.query && parsedUrl.query.query) {
		var query = parsedUrl.query.query,
			dataReturnedCount = 0,
			data = querystring.stringify({
				'query': query
			});

		//lauch all requests
		for (var i = 0, len = opts.length; i < len; i++) {
			var req = http.request(opts[i], function(res) {
				res.setEncoding('utf-8');
				res.on('data', function(data) {
					dataReturnedCount++;
					if (data.substring(0, 5) == '<page') {
						sRes.end(data);
					} else if (dataReturnedCount == len) {
						sRes.end('No results.');
					}
				});
			});
			req.write(data);
			req.end();
		}

	} else {
		sRes.end('Keywords are needed.')
	}
}).listen(8080);



// var	data = querystring.stringify({
// 		'query': 'Anarchism'
// 	});

// var req = http.request(opts, function(res) {
// 	res.setEncoding('utf-8');

// 	res.on('data', function(data) {
// 		console.log('The result is shown below:');
// 		console.log(data);
// 	})
// });

// req.write(data);

// req.end();