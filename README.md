# Silex IoC
Class resolver for the [Silex](http://silex.sensiolabs.org/) application.

This project is a bridge between [Pimple IoC](https://github.com/jonsa/pimple-ioc) and the Silex Application.

## Installation
Add the IoC container to your ```composer.json``` using the command line.
```
composer require jonsa/silex-ioc
```

## Usage
The class resolver is registered in Silex as a ```ServiceProvider```
```php
use Jonsa\PimpleResolver\ServiceProvider as PimpleResolverServiceProvider;
use Jonsa\SilexResolver\ServiceProvider as SilexResolverServiceProvider;
use Silex\Application;

$app = new Application();
$app->register(new PimpleResolverServiceProvider());
$app->register(new SilexResolverServiceProvider());
```
### Events
The Silex event dispatcher is registered with PimpleResolver which makes it easy to inject into the resolver.
```php
use Jonsa\PimpleResolver\Event\ClassResolvedEvent;
use Jonsa\PimpleResolver\Events as ResolverEvents;

$app->on(ResolverEvents::CLASS_RESOLVED, function (ClassResolvedEvent $event) {
    $object = $event->getResolvedObject();
    ...
});
```

## Configuration
The ServiceProvider has one configuration parameter.
```php
class ServiceProvider implements ServiceProviderInterface {
    public function __construct($resolveControllers = true)
    {
        ...
    }
}
```

```$resolveControllers``` tells the ServiceProvider whether to replace the built-in controller resolver in Silex. If set to true controllers will be resolved out of the IoC container.