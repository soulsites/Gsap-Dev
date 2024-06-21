const path = require('path');

module.exports = {
    entry: './src/Public/js/public-scripts.js',
    output: {
        filename: 'public-scripts.min.js',
        path: path.resolve(__dirname, 'src/Public/js')
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env']
                    }
                }
            }
        ]
    },
    mode: 'production'
};