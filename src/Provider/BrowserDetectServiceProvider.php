<?php

namespace hisorange\BrowserDetect\Provider;

use hisorange\BrowserDetect\Parser\Parser;
use hisorange\BrowserDetect\Result;
use Illuminate\Support\ServiceProvider;

/**
 * Class BrowserDetectServiceProvider
 *
 * @package hisorange\BrowserDetect\Provider
 */
class BrowserDetectServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/config.php'  => config_path('hisorange/browser-detect/browser-detect-config.php'),
            __DIR__ . '/../config/plugins.php' => config_path('hisorange/browser-detect/browser-detect-plugins.php'),
        ]);
    }

    /**
     * Register the service provider.
     * @since 1.0.0 the function split into parser & result registration to be more extendable.
     *
     * @return void
     */
    public function register()
    {
        $this->registerParser();
        $this->registerResult();
    }

    /**
     * @since 1.0.0 Register the parser.
     *
     * @return void
     */
    public function registerParser()
    {
        $this->app->singleton('browser-detect.parser', function ($app) {
            return new Parser($app);
        });
    }

    /**
     * @since 1.0.0 Register the result.
     *
     * @return void
     */
    public function registerResult()
    {
        $this->app->bind('browser-detect.result', Result::class);
    }

    /**
     * Get the services provided by the provider.
     * @since 1.0.0 Component names changed to avoid conflict with older versions.
     *
     * @return array
     */
    public function provides()
    {
        return ['browser-detect.parser', 'browser-detect.result'];
    }

}