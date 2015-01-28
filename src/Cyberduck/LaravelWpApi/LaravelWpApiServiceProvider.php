<?php namespace Cyberduck\LaravelWpApi;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;

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
		$this->package('cyberduck/laravel-wp-api');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bindShared('wp-api', function ($app) {

            $endpoint = $this->app['config']->get('laravel-wp-api::endpoint');
            $client   = new Client();
            
            return new WpApi($endpoint, $client);

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
