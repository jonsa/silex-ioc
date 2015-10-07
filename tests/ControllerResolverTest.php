<?php namespace Jonsa\SilexResolver\Test;

use Jonsa\PimpleResolver\Events as ResolverEvents;
use Jonsa\PimpleResolver\ServiceProvider as ResolverServiceProvider;
use Jonsa\SilexResolver\ControllerResolver;
use Jonsa\SilexResolver\ServiceProvider;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ControllerResolverTest
 *
 * @package Jonsa\SilexResolver\Test
 * @author Jonas Sandström
 */
class ControllerResolverTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Application
     */
    private $app;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->app = new Application();
        $this->app->register(new ResolverServiceProvider());
        $this->app->register(new ServiceProvider());
    }

    public function testControllerResolverIsOverridden()
    {
        $this->assertInstanceOf('Jonsa\\SilexResolver\\ControllerResolver', $this->app['resolver']);
    }

    public function testResolveController()
    {
        $resolver = new ControllerResolver($this->app);
        $class = 'Jonsa\\SilexResolver\\Test\\Data\\IndexController';
        $method = "$class::index";

        $request = Request::create('/');
        $request->attributes->set('_controller', $method);

        $this->app->get('/', $method);

        $callable = $resolver->getController($request);

        $this->assertInstanceOf($class, $callable[0]);
    }

    public function testResolverEvents()
    {
        $class = 'Jonsa\\SilexResolver\\Test\\Data\\FooClass';
        $count = 1;

        $this->app->on(ResolverEvents::CLASS_RESOLVED, function ($event) use ($class, &$count) {
            /** @var \Jonsa\PimpleResolver\Event\ClassResolvedEvent $event */
            $this->assertInstanceOf($class, $event->getResolvedObject());

            $count++;
        });

        $this->app['make']($class);

        $this->assertEquals(2, $count);
    }

}
