<?php

/*
 * This file is part of the FSi Component package.
 *
 * (c) Lukasz Cybula <lukasz@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FSi\Component\Reflection\Tests\Fixture;

interface ClassAInterface
{
    public function publicMethod($paramE, $paramF);
}

class ClassAParentParent
{
    public $publicProperty3;

    public function publicMethod3($paramE, $paramF)
    {
        return $paramE . '=' .$paramF;
    }
}

class ClassAParent extends ClassAParentParent
{
    public $publicProperty2;

    public function publicMethod2($paramE, $paramF)
    {
        return $paramE . '=' .$paramF;
    }
}

class ClassA extends ClassAParent implements ClassAInterface
{
    private $privateProperty;

    protected $protectedProperty;

    public $publicProperty;

    public function __construct($constructorParam)
    {

    }

    private function privateMethod($paramA, $paramB)
    {
        return $paramA . '-' .$paramB;
    }

    protected function protectedMethod($paramC, $paramD)
    {
        return $paramC . '+' .$paramD;
    }

    public function publicMethod($paramE, $paramF)
    {
        return $paramE . '=' .$paramF;
    }
}
