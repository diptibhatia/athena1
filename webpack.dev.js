const path = require('path');
const common = require('./webpack.common');
const { merge } = require('webpack-merge');

module.exports = merge(common, {
    mode: 'development',
    output: {
        filename: 'bundled.js',
        path: path.resolve(__dirname, 'app')
    }, 
    devServer: {
        before: function(app, server) {
            server._watch('./app/**/*.html');
        },
        contentBase: path.join(__dirname, 'app'),
        hot: true,
        port: 3001,
        host: '127.0.0.1'
    },
    module: {
        rules: [
            {
                test: /\.scss$/,
                use: ["style-loader", "css-loader", "sass-loader"]
            },
            {
                test: /\.(ttf|eot|svg|gif|woff|woff2)(\?v=[0-9]\.[0-9]\.[0-9])?$/,
                use: [{
                    loader: 'file-loader',
                }]
            }
        ]
    },
    watch: true
});