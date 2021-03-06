const path = require('path');
const common = require('./webpack.common');
const { merge } = require('webpack-merge');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = merge(common, {
    mode: 'production',
    output: {
        filename: 'prodbundled.js',
        path: path.resolve(__dirname, 'athenawebsite')
    },
    plugins: [
        new MiniCssExtractPlugin({ filename: 'main.css' })
    ], 
    module: {
        rules: [
            {
                test: /\.scss$/,
                use: [MiniCssExtractPlugin.loader, "css-loader", {
                    loader: 'postcss-loader',
                    options: {
                      plugins: function () {
                        return [
                          require('autoprefixer')
                        ];
                      }
                    }
                  }, "sass-loader"]
            }
        ]
    }
});