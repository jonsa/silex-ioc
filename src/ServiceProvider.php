<?php namespace Jonsa\SilexResolver;

use Jonsa\PimpleResolver\Contract\ClassResolver as ClassResolverContract;
use Jonsa\PimpleResolver\ServiceProvider as ResolverServiceProvider;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;

/**
 * Class ServiceProvider
 *
 * @package Jonsa\SilexResolver
 * @author Jonas Sandström
 */
class ServiceProvider implements ServiceProviderInterface {

	/**
	 * @var bool
	 */
	private $resolveControllers;

	/**
	 * @param bool $resolveControllers
	 */
	public function __construct($resolveControllers = true)
	{
		$this->resolveControllers = (bool) $resolveControllers;
	}

	/**
	 * Registers services on the given container.
	 *
	 * This method should only be used to configure services and parameters.
	 * It should not get services.
	 *
	 * @param Container $container A container instance
	 */
	public function register(Container $container)
	{
		if ($this->resolveControllers) {
			$container['resolver'] = function (Application $app) {
				return new ControllerResolver($app, $app['logger']);
			};
		}

		$container->extend(
			ResolverServiceProvider::CLASS_RESOLVER,
			function (ClassResolverContract $resolver, Container $app) {
				$resolver->registerEventListener(function ($event, $type) use ($app) {
					$app['dispatcher']->dispatch($type, new EventWrapper($event));
				});

				return $resolver;
			}
		);
	}

}
