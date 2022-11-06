const path = require('path')

module.exports = {
	mode: 'production',
	entry: './js/src/index.js',
	output: {
		path: path.join(__dirname, 'js'),
		filename: 'bundle.js'
	},
	module: {
		rules: [
			{
				test: /\.m?js$/,
				exclude: /node_modules/,
				use: {
					loader: 'babel-loader',
					options: {
						presets: ['@babel/preset-env']
					}
				}
			}
		]
	}
}