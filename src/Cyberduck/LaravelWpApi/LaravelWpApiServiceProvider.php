<?php namespace Cyberduck\LaravelWpApi;

use Illuminate\Support\ServiceProvider;

class LaravelWpApiServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->publishes([
            __DIR__.'/../../config/config.php' => config_path('wp-api.php'),
        ]);
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bindShared('wp-api', function ($app) {

            $endpoint = $this->app['config']->get('wp-api.endpoint');
            $auth     = $this->app['config']->get('wp-api.auth');
            $client   = $this->app->make('GuzzleHttp\Client');
            $curlOpt = $this->app['config']->get('wp-api.curl');
            if ($curlOpt && !empty($curlOpt)) {
                $client->setDefaultOption('config', ['curl' => $this->app['config']->get('wp-api.curl')]);
            }
            
            return new WpApi($endpoint, $client, $auth);

        });

        $this->app->bind('Cyberduck\LaravelWpApi\WpApi', function($app)
        {
            return $app['wp-api'];
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['wp-api'];
	}

}
