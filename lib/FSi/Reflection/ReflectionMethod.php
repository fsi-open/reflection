<?php

namespace FSi\Reflection;

class ReflectionMethod extends \ReflectionMethod
{
    protected static $methods = array();

    final public function __construct($class, $name)
    {
        $bt = debug_backtrace();
        if (!isset($bt[1]['class']) || ($bt[1]['class'] !== __CLASS__))
            throw new ReflectionException('ReflectionClass\' constructor cannot be called from outside the class');
        parent::__construct($class, $name);
    }

    public static function factory($class, $method)
    {
        if (is_object($class))
            $class = get_class($class);
        $class = (string)$class;
        if (!isset(self::$methods[$class][$method])) {
            if (!isset(self::$methods[$class]))
                self::$methods[$class] = array();
            self::$methods[$class][$method] = new self($class, $method);
            self::$methods[$class][$method]->setAccessible(true);
        }
        return self::$methods[$class][$method];
    }

    public function getDeclaringClass()
    {
        return ReflectionClass::factory($this->class);
    }

    public function getExtension()
    {
        $extension = $this->getExtensionName();
        if (isset($extension))
            return ReflectionExtension::factory($this->getExtensionName());
        else
            return null;
    }
}
