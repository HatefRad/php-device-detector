'use strict'

const {VueLoaderPlugin} = require('vue-loader')

module.exports = {
    mode: 'production',
    entry: [
        './public/js/main.js'
    ],
    module: {
        rules: [
            {
                test: /\.vue$/,
                use: 'vue-loader'
            },
            {
                test: /\.css$/,
                use: [
                    'vue-style-loader',
                    'css-loader'
                ]
            }
        ]
    },
    plugins: [
        new VueLoaderPlugin()
    ],
    resolve: {
        extensions: ['.tsx', '.ts', '.js', '.vue'],
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js'
        }
    }
}
