<?php

namespace FSi\Reflection\Fixture;

class ClassA
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
