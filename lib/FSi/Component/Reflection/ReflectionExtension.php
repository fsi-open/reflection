<?php

namespace FSi\Component\Reflection;

class ReflectionExtension extends \ReflectionExtension
{
    protected static $extensions = array();

    final public function __construct($name)
    {
        $bt = debug_backtrace();
        if (!isset($bt[1]['class']) || ($bt[1]['class'] !== __CLASS__))
            throw new ReflectionException('ReflectionClass\' constructor cannot be called from outside the class');
        parent::__construct($name);
    }

    public static function factory($extension)
    {
        $extension = (string)$extension;
        if (!isset(self::$extensions[$extension]))
            self::$extensions[$extension] = new self($extension);
        return self::$extensions[$extension];
    }

    public function getClasses()
    {
        $classNames = $this->getClassNames();
        $classes = array();
        foreach ($classNames as $class)
            $classes[$class] = ReflectionClass::factory($class);
        return $classes;
    }

    public function getFunctions()
    {
        throw new ReflectionException('This method is not implemented due to performance reasons');
    }
}
