const path = require('path')
const MiniCSSExtractPlugin = require('mini-css-extract-plugin')

const config = {
	entry: './src/index.js',
	output: {
		path: path.resolve(__dirname, 'dist'),
		filename: 'js/bundle.js'
	},
	module: {
		rules: [
			{
				test: /\.m?js$/,
				exclude: /(node_modules|bower_components|Rubbish)/,
				use: {
					loader: 'babel-loader',
					options: {
						"presets": [["@babel/preset-env", {
							"useBuiltIns": "usage",
							"corejs": "3.26.1"
						}]],
						cacheDirectory: true
					}
				}
			},
			{
				test: /\.html$/i,
				use: {
					loader: 'html-loader',
					options: {
						minimize: true
					}
				}
			},
			{
				test: /\.css$/,
				use: ['style-loader', 'css-loader']
			},
			{
				test: /\.styl$/,
				use: [
					MiniCSSExtractPlugin.loader,
					{
						loader: 'css-loader',
						options: {
							sourceMap: true
						}
					},
					{
						loader: 'stylus-loader',
						options: {
							stylusOptions: {
								use: [require('nib')()],
								import: ['nib'],
								includeCSS: true,
								lineNumbers: true,
								hoistAtrules: true,
								compress: true
							},
							sourceMap: true
						}
					}
				]
			},
			{
				test: /\.(jade|pug)$/,
				use: [
					'apply-loader',
					'pug-loader'
				]
			}
		]
	},
	plugins: [new MiniCSSExtractPlugin({filename: 'css/bundle.css'})]
}

const isProduction = process.env.NODE_ENV == 'production'
module.exports = () => {
	config.mode = isProduction ? 'production' : 'development'
	config.devtool = isProduction ? false : 'source-map'
	return config
}