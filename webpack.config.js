const webpack = require('webpack');
const path = require('path');

const config = {
    entry: './js/index.js',
    output: {
        path: path.resolve(__dirname, 'public'),
        filename: 'bundle.js',
    },
    module: {
        rules: [
            {
                test: /\.(js|jsx)$/,
                use: 'babel-loader',
                exclude: /node_modules/,
            },
            {
                test: /\.scss$/,
                use: ['style-loader', 'css-loader', 'sass-loader'],
            },
            {
                test: /\.svg$/,
                use: 'file-loader',
            },
            {
                test: /\.png$/,
                use: [
                    {
                        loader: 'url-loader',
                        options: {
                            mimetype: 'image/png',
                        },
                    },
                ],
            },
        ],
    },
};

module.exports = config;
