const path = require('path')
const webpack = require('webpack')
const { VueLoaderPlugin } = require('vue-loader')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const HtmlWebpackPlugin = require('html-webpack-plugin')

module.exports = (env = {}) => ({
  mode: env.prod ? 'production' : 'development',
  devtool: env.prod ? 'source-map' : 'eval-cheap-module-source-map',
  entry: {
    main: path.resolve(__dirname, './javascript/src/main.js'),
  },
  output: {
    filename: 'js/[name].[contenthash:8].bundle.js',
    path: path.resolve(__dirname, './dist'),
    publicPath: '/',
  },
  resolve: {
    alias: {
      '@': path.resolve(__dirname, '/javascript/src'),
    },
    extensions: ['.vue', '.js'],
  },
  module: {
    rules: [
      {
        test: /\.vue$/,
        use: 'vue-loader',
      },
      {
        test: /\.js$/,
        loader: 'babel-loader',
        exclude: /node_modules/,
      },
      {
        test: /\.png$/,
        use: {
          loader: 'url-loader',
          options: { limit: 8192 },
        },
      },
      {
        test: /\.css$/,
        use: [
          { loader: MiniCssExtractPlugin.loader },
          { loader: 'css-loader' },
          'postcss-loader',
        ],
      },
    ],
  },
  plugins: [
    new VueLoaderPlugin(),
    new MiniCssExtractPlugin({
      filename: 'css/[name].[contenthash:8].css',
    }),
    new webpack.DefinePlugin({
      __VUE_OPTIONS_API__: 'true',
      __VUE_PROD_DEVTOOLS__: 'false',
    }),
    new HtmlWebpackPlugin({
      template: 'javascript/html/index.html',
    }),
  ],
  optimization: {
    splitChunks: {
      cacheGroups: {
        default: {
          name: 'main',
          chunks: 'all',
          test: /javascript/,
          priority: 20,
        },
        vendors: false,
        node_modules: {
          name: 'vendor',
          chunks: 'all',
          test: /node_modules/,
          priority: 10,
        },
      },
    },
  },
  watchOptions: {
    ignored: /node_modules/,
  },
  devServer: {
    inline: true,
    hot: true,
    stats: 'minimal',
    contentBase: __dirname,
    overlay: true,
  },
})
