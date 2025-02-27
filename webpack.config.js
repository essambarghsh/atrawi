const path = require('path');

module.exports = {
    entry: {
        app: './src/ts/app.ts',
        admin: './src/ts/core/admin/admin.ts'
    },
    output: {
        filename: 'js/[name].js',
        path: path.resolve(__dirname, 'assets')
    },
    module: {
        rules: [
            {
                test: /\.ts$/,
                use: 'ts-loader',
                exclude: /node_modules/
            }
        ]
    },
    resolve: {
        extensions: ['.ts', '.js']
    },
    devtool: 'source-map'
};