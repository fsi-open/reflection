<?php

namespace FSi\Component\Reflection;

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

    public static function factory($class, $property = null)
    {
        if (is_object($class))
            $class = get_class($class);
        $class = (string)$class;
        if (!isset(self::$properties[$class])) {
            $classReflection = new \ReflectionClass($class);
            $properties = $classReflection->getProperties();
            self::$properties[$class] = array();
            foreach ($properties as $propertyReflection) {
                self::$properties[$class][$propertyReflection->name] = new self($class, $propertyReflection->name);
                self::$properties[$class][$propertyReflection->name]->setAccessible(true);
            }
        }
        if (isset($property)) {
            if (!isset(self::$properties[$class][$property])) {
                self::$properties[$class][$property] = new self($class, $property);
                self::$properties[$class][$property]->setAccessible(true);
            }
            return self::$properties[$class][$property];
        } else
            return self::$properties[$class];
    }

    public function getDeclaringClass()
    {
        return ReflectionClass::factory($this->class);
    }
}
