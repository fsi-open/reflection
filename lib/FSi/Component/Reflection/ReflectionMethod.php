<?php

namespace FSi\Component\Reflection;

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

    public static function factory($class, $method = null)
    {
        if (is_object($class))
            $class = get_class($class);
        $class = (string)$class;
        if (!isset(self::$methods[$class])) {
            $classReflection = new \ReflectionClass($class);
            $methods = $classReflection->getMethods();
            self::$methods[$class] = array();
            foreach ($methods as $methodReflection) {
                self::$methods[$class][$methodReflection->name] = new self($class, $methodReflection->name);
                self::$methods[$class][$methodReflection->name]->setAccessible(true);
            }
        }
        if (isset($method)) {
            if (!isset(self::$methods[$class][$method])) {
                self::$methods[$class][$method] = new self($class, $method);
                self::$methods[$class][$method]->setAccessible(true);
            }
            return self::$methods[$class][$method];
        } else
            return self::$methods[$class];
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
