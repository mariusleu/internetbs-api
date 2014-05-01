<?php namespace Softservlet\Internetbs;

use Illuminate\Support\ServiceProvider;
use Softservlet\Internetbs\Api;
use Softservlet\Internetbs\Request\HttpRequest;

class InternetbsServiceProvider extends ServiceProvider {

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
		$this->package('softservlet/internetbs');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('Softservlet\Internetbs\Api', function($app){
			return new Api(
				new HttpRequest(
					$app['config']->get('internetbs::apiKey'),
					$app['config']->get('internetbs::password'),
					$app['config']->get('internetbs::test')
				)
			);	
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
