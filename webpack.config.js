const path = require('path')

module.exports = {
	mode: 'production',
	entry: './ecmascript/app.js',
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
					presets: [
						[
							"@babel/preset-env",
							{
								targets: {
									edge: "17",
									firefox: "47.0.2"
								},
								useBuiltIns: "usage",
								corejs: "3.26.1"
							}
						]
					]
				}
			}
		}]
	}
}