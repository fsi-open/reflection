<?php

namespace FSi\Reflection;

class ReflectionFunction extends \ReflectionFunction
{
    protected static $functions = array();

    final public function __construct($function)
    {
        $bt = debug_backtrace();
        if (!isset($bt[1]['class']) || ($bt[1]['class'] !== __CLASS__))
            throw new ReflectionException('ReflectionClass\' constructor cannot be called from outside the class');
        parent::__construct($function);
    }

    public static function factory($function)
    {
        $function = (string)$function;
        if (!isset(self::$functions[$function]))
            self::$functions[$function] = new self($function);
        return self::$functions[$function];
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
