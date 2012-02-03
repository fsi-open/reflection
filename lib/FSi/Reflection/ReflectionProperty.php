<?php

namespace FSi\Reflection;

class ReflectionProperty extends \ReflectionProperty
{
    protected static $properties = array();

    final public function __construct($class, $name)
    {
        $bt = debug_backtrace();
        if (!isset($bt[1]['class']) || ($bt[1]['class'] !== __CLASS__))
            throw new ReflectionException('ReflectionClass\' constructor cannot be called from outside the class');
        parent::__construct($class, $name);
    }

    public static function factory($class, $property)
    {
        if (is_object($class))
            $class = get_class($class);
        $class = (string)$class;
        if (!isset(self::$properties[$class][$property])) {
            if (!isset(self::$properties[$class]))
                self::$properties[$class] = array();
            self::$properties[$class][$property] = new self($class, $property);
            self::$properties[$class][$property]->setAccessible(true);
        }
        return self::$properties[$class][$property];
    }

    public function getDeclaringClass()
    {
        return ReflectionClass::factory($this->class);
    }
}
