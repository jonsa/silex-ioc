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
		return $this->app[PimpleResolverServiceProvider::CLASS_RESOLVER]->resolve($class);
	}

}
