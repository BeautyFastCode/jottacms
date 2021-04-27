const Encore = require('@symfony/webpack-encore');
const GoogleFontsPlugin = require("@beyonk/google-fonts-webpack-plugin")

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

/**
 * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 * Frontend config
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */
Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/frontend/')
    // public path used by the web server to access the output path
    .setPublicPath('/build/frontend')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('app', './assets/frontend/app.js')

    // enables the Symfony UX Stimulus bridge (used in assets/bootstrap.js)
    .enableStimulusBridge('./assets/frontend/controllers.json')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    .configureBabel((config) => {
        config.plugins.push('@babel/plugin-proposal-class-properties');
    })

    // enables @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })

    // enables Sass/SCSS support
    .enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment if you use React
    //.enableReactPreset()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    //.autoProvidejQuery()

    /*
     * This plugin download the Google Fonts
     */
    .addPlugin(
        new GoogleFontsPlugin({
            fonts: [
                { family: "Pacifico", subsets: [ "latin", "latin-ext" ] }
            ],
            path: 'fonts/',
        })
    )
;

const frontendConfig = Encore.getWebpackConfig();

// Set a unique name for the config (needed later!)
frontendConfig.name = 'frontend';

// reset Encore to build the second config
Encore.reset();

/**
 * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 * Admin config
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */
Encore
    .setOutputPath('public/build/admin/')
    .setPublicPath('/build/admin')
    .addEntry('app', './assets/admin/app.js')
    .copyFiles([
        {from: './node_modules/@jdinabox/ckeditor5-build-markdown/build', to: 'ckeditor5/[path][name].[ext]'}
    ])
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .enableSassLoader()

const adminConfig = Encore.getWebpackConfig();
adminConfig.name = 'admin';
Encore.reset();

/**
 * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 * Export the final configuration as an array of multiple configurations
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */
module.exports = [frontendConfig, adminConfig];
