const common = require('./webpack.common.js');
const merge = require('webpack-merge');

// Used to create a local server
const LiveReloadPlugin = require('webpack-livereload-plugin');

// Config files.
const settings = require( './project.config.js' );

module.exports = merge(common, {
  mode: 'development',
  devtool: 'source-map',
  plugins: [

    // Automatic browser refresh for CSS and JS changes
    new LiveReloadPlugin({
        port: 35729,
        protocol: "https"
    })
  ]

});