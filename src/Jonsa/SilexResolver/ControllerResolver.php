<?php namespace Jonsa\SilexResolver;

use Jonsa\PimpleResolver\ServiceProvider as PimpleResolverServiceProvider;

/**
 * Class ControllerResolver
 *
 * @package Jonsa\SilexResolver
 * @author Jonas Sandström
 */
class ControllerResolver extends \Silex\ControllerResolver {

	/**
	 * {@inheritdoc}
	 */
	protected function instantiateController($class)
	{
		$key = $this->app[PimpleResolverServiceProvider::CLASS_RESOLVER_KEY];

		return $this->app[$key]($class);
	}

}
