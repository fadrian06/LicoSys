const path = require('path')

const config = {
	entry: './src/index.js',
	output: {
		path: path.resolve(__dirname, 'dist'),
		filename: 'bundle.js'
	},
	devServer: {
		open: true,
		host: 'localhost',
	},
	module: {
		rules: [
			{
				test: /\.(js|jsx)$/i,
				loader: 'babel-loader',
			}
		]
	}
}

const isProduction = process.env.NODE_ENV == 'production'
module.exports = () => {
	config.mode = isProduction ? 'production' : 'development'
	return config
}