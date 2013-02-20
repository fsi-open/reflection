<?php

/*
 * This file is part of the FSi Component package.
 *
 * (c) Lukasz Cybula <lukasz@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FSi\Component\Reflection;

class ReflectionFunction extends \ReflectionFunction
{
    protected static $functions = array();

    /**
     * Constructs a new ReflectionFunction object.
     *
     * @param string $function
     * @throws ReflectionException
     * @return ReflectionFunction
     */
    final public function __construct($function)
    {
        $bt = debug_backtrace();
        if (!isset($bt[1]['class']) || ($bt[1]['class'] !== __CLASS__))
            throw new ReflectionException('ReflectionClass\' constructor cannot be called from outside the class');
        parent::__construct($function);
    }

    /**
     * Constructs a new ReflectionFunction object from function name and store it in cache.
     * If object already exists in cache it will taken from there instead of creating
     * new object
     *
     * @param string $class
     * @return ReflectionFunction
     */
    public static function factory($function)
    {
        $function = (string)$function;
        if (!isset(self::$functions[$function]))
            self::$functions[$function] = new self($function);
        return self::$functions[$function];
    }

}
