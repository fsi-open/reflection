<?php

namespace FSi\Component\Reflection;

class ReflectionClass extends \ReflectionClass
{
    protected static $classes = array();

    final public function __construct($class)
    {
        $bt = debug_backtrace();
        if (!isset($bt[1]['class']) || ($bt[1]['class'] !== __CLASS__))
            throw new ReflectionException('ReflectionClass\' constructor cannot be called from outside the class');
        parent::__construct($class);
    }

    public static function factory($class)
    {
        if (is_object($class))
            $class = get_class($class);
        $class = (string)$class;
        if (!isset(self::$classes[$class]))
            self::$classes[$class] = new self($class);
        return self::$classes[$class];
    }

    public function getExtension()
    {
        $extension = $this->getExtensionName();
        if (isset($extension))
            return ReflectionExtension::factory($this->getExtensionName());
        else
            return null;
    }

    public function getInterfaces()
    {
        $interfaceNames = $this->getInterfaceNames();
        $interfaces = array();
        foreach ($interfaceNames as $interface)
            $interfaces[$interface] = ReflectionClass::factory($interface);
        return $interfaces;
    }

    public function getTraits()
    {
        $traitNames = $this->getTraitNames();
        $traits = array();
        foreach ($traitNames as $trait)
            $traits[$trait] = ReflectionClass::factory($trait);
        return $traits;
    }

    public function getParentClass()
    {
        $parentClass = parent::getParentClass();
        if ($parentClass)
            return ReflectionClass::factory($parentClass->getName());
    }

    public function getMethod($method)
    {
        return ReflectionMethod::factory($this->name, $method);
    }

    protected function filter($items, $filter)
    {
        $filtered = array();
        foreach ($items as $item)
            if ($item->getModifiers() & $filter)
                $filtered[] = $item;
        return $filtered;
    }

    public function getMethods($filter = null)
    {
        $methods = ReflectionMethod::factory($this->name);
        if (isset($filter))
            return $this->filter($methods, $filter);
        else
            return $methods;
    }

    public function getProperty($property)
    {
        return ReflectionProperty::factory($this->name, $property);
    }

    public function getProperties($filter = null)
    {
        $properties = ReflectionProperty::factory($this->name);
        if (isset($filter))
            return $this->filter($properties, $filter);
        else
            return $properties;
    }

}
