const path = require("path");

// Used to compile Sass into CSS
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");
const FixStyleOnlyEntriesPlugin = require("webpack-fix-style-only-entries");
const globImporter = require("node-sass-glob-importer");
const autoprefixer = require("autoprefixer");

// Used for image optimization
const ImageminPlugin = require("imagemin-webpack-plugin").default;
const CopyWebpackPlugin = require("copy-webpack-plugin");

// SVG Sprites
// const SVGSpritemapPlugin = require("svg-spritemap-webpack-plugin");

// Config files.
const settings = require("./project.config.js");

module.exports = {
    entry: settings.entries,
    output: {
        filename: "[name].js",
        path: path.resolve(__dirname, "../assets/js")
    },
    externals: {
        jquery: "jQuery"
    },
    module: {
        rules: [
            {
                // Tests JS for errors using .eslintrs.js
                test: /\.js?$/,
                exclude: [/libs/, /node_modules/],
                enforce: "pre",
                loader: "eslint-loader",
                //exclude: '', // Exclude files or directories from linting
                options: {
                    emitWarning: true,
                    configFile: "./.eslintrc.js"
                }
            },

            {
                // Run JS through Babel for better browser support
                test: /\.js$/,
                exclude: /libs/,
                use: [
                    {
                        loader: "babel-loader",
                        options: {
                            sourceMap: true
                        }
                    },
                    // Allow for globbing of JS files
                    {
                        loader: "webpack-import-glob-loader"
                    }
                ]
            },

            // Compile all .scss files into CSS
            {
                test: /\.s[ac]ss$/i,
                use: [
                    {
                        loader: MiniCssExtractPlugin.loader
                    },
                    {
                        loader: "css-loader",
                        options: {
                            sourceMap: true,
                            url: false
                        }
                    },
                    {
                        loader: "postcss-loader"
                    },
                    {
                        loader: "sass-loader",
                        options: {
                            importer: globImporter(),
                            sourceMap: true
                        }
                    }
                ]
            }
        ]
    },

    plugins: [
        // Remove extra files created by webpack
        new FixStyleOnlyEntriesPlugin({
            silent: true
        }),

        // Extract CSS to this location
        new MiniCssExtractPlugin({
            filename: "../css/[name].css"
        }),

        // Optimize images
        new CopyWebpackPlugin([
            {
                from: "src/img/",
                to: "../img/"
            }
        ]),
        new ImageminPlugin({
            test: /\.(jpe?g|png|gif)$/i
        }),
        // SVG Spritemaps
        // new SVGSpritemapPlugin("src/icons/*.svg", {
        //     output: {
        //         filename: "../icons/icons.svg",
        //         svgo: true,
        //     },
        //     sprite: {
        //         prefix: false,
        //     }
        // })
    ],

    optimization: {
        minimizer: [
            // Enable the css minification plugin
            new OptimizeCSSAssetsPlugin({
                cssProcessorOptions: {
                    map: {
                        inline: false
                    }
                }
            })
        ]
    },

    // Cleaner Webpack console messages
    stats: {
        cached: false,
        cachedAssets: false,
        chunks: false,
        chunkModules: false,
        chunkOrigins: false,
        modules: false,
        entrypoints: false,
        moduleTrace: false
    }
};
