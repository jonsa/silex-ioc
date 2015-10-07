<?php namespace Jonsa\SilexResolver;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class EventWrapper
 *
 * @package Jonsa\SilexResolver
 * @author Jonas Sandström
 */
class EventWrapper extends Event
{

    /**
     * @var mixed
     */
    public $event;

    /**
     * @param mixed $event
     */
    public function __construct($event)
    {
        $this->event = $event;
    }

    /**
     * @param string $name
     * @param array $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array(array($this->event, $name), $arguments);
    }

    /**
     * @param string $name
     */
    function __get($name)
    {
        return $this->event->$name;
    }

}
