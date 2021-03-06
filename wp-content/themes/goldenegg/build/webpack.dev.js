const common = require('./webpack.common.js');
const merge = require('webpack-merge');

// Used to create a local server
const LiveReloadPlugin = require('webpack-livereload-plugin');

// Config files.
const settings = require( './project.config.js' );

const LivereloadWebpackPlugin = require('webpack-livereload-plugin')
const md5File = require('md5-file')

// Allows for CSS to be injected without reload
LivereloadWebpackPlugin.prototype.done = function done(stats) {
    this.fileHashes = this.fileHashes || {}

    const fileHashes = {}
    for (let file of Object.keys(stats.compilation.assets)) {
        fileHashes[file] = md5File.sync(stats.compilation.assets[file].existsAt)
    }

    const toInclude = Object.keys(fileHashes).filter((file) => {
        if (this.ignore && file.match(this.ignore)) {
            return false
        }
        return !(file in this.fileHashes) || this.fileHashes[file] !== fileHashes[file]
    })

    if (this.isRunning && toInclude.length) {
        this.fileHashes = fileHashes
        console.log('Live Reload: Reloading ' + toInclude.join(', '))
        setTimeout(
            function onTimeout() {
                this.server.notifyClients(toInclude)
            }.bind(this)
        )
    }
}

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