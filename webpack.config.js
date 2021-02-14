const path = require('path');

module.exports = [
	{
		output: {
			filename: 'login.min.js',
			path: path.resolve(__dirname, 'dist/js/login'),
			libraryTarget: 'commonjs'
		},
		name: 'commonjs',
		entry: ['./assets/plugins/jquery/jquery.min.js"', './assets/plugins/bootstrap/js/bootstrap.bundle.min.js', './assets/js/adminlte.min.js'],
		mode: 'production'
	}
];