<?php

namespace FSi\Reflection;

use FSi\Reflection\Fixture\ClassA;

class SampleTest extends \PHPUnit_Framework_TestCase
{
    public function testClass()
    {
        $classReflection1 = ReflectionClass::factory('FSi\Reflection\Fixture\ClassA');
        $classReflection2 = ReflectionClass::factory('FSi\Reflection\Fixture\ClassA');
        $this->assertSame($classReflection1, $classReflection2);

        $classReflection3 = $classReflection2->getMethod('privateMethod')->getDeclaringClass();
        $this->assertSame($classReflection2, $classReflection3);

        $classReflection4 = ReflectionClass::factory(new ClassA('param'));
        $this->assertSame($classReflection1, $classReflection4);

        $classReflection5 = $classReflection2->getProperty('privateProperty')->getDeclaringClass();
        $this->assertSame($classReflection2, $classReflection5);

        $obj = new ClassA('param');
        $classReflection6 = ReflectionClass::factory($obj);
        $this->assertSame($classReflection2, $classReflection6);
    }

    public function testMethod()
    {
        $methodReflection1 = ReflectionMethod::factory('FSi\Reflection\Fixture\ClassA', 'protectedMethod');
        $methodReflection2 = ReflectionMethod::factory('FSi\Reflection\Fixture\ClassA', 'protectedMethod');
        $this->assertSame($methodReflection1, $methodReflection2);

        $methodReflection3 = ReflectionClass::factory('FSi\Reflection\Fixture\ClassA')->getMethod('protectedMethod');
        $this->assertSame($methodReflection1, $methodReflection3);

        $obj = new ClassA('param');
        $methodReflection4 = ReflectionMethod::factory($obj, 'protectedMethod');
        $this->assertSame($methodReflection1, $methodReflection4);

        $res = $methodReflection1->invoke($obj, 'foo', 'bar');
        $this->assertEquals($res, 'foo+bar');

        $methodReflection5 = ReflectionMethod::factory('FSi\Reflection\Fixture\ClassA', 'privateMethod');
        $res = $methodReflection5->invoke($obj, 'foo', 'bar');
        $this->assertEquals($res, 'foo-bar');

        $methodReflection6 = ReflectionMethod::factory('FSi\Reflection\Fixture\ClassA', 'publicMethod');
        $res = $methodReflection6->invoke($obj, 'foo', 'bar');
        $this->assertEquals($res, 'foo=bar');
    }

    public function testProperty()
    {
        $propertyReflection1 = ReflectionProperty::factory('FSi\Reflection\Fixture\ClassA', 'protectedProperty');
        $propertyReflection2 = ReflectionProperty::factory('FSi\Reflection\Fixture\ClassA', 'protectedProperty');
        $this->assertSame($propertyReflection1, $propertyReflection2);

        $propertyReflection3 = ReflectionClass::factory('FSi\Reflection\Fixture\ClassA')->getProperty('protectedProperty');
        $this->assertSame($propertyReflection1, $propertyReflection3);

        $obj = new ClassA('param');
        $propertyReflection4 = ReflectionProperty::factory($obj, 'protectedProperty');
        $this->assertSame($propertyReflection1, $propertyReflection4);

        $propertyReflection1->setValue($obj, 'foo');
        $this->assertAttributeEquals('foo', 'protectedProperty', $obj);
        $this->assertEquals('foo', $propertyReflection1->getValue($obj));

        $propertyReflection5 = ReflectionProperty::factory('FSi\Reflection\Fixture\ClassA', 'privateProperty');
        $propertyReflection5->setValue($obj, 'bar');
        $this->assertAttributeEquals('bar', 'privateProperty', $obj);
        $this->assertEquals('bar', $propertyReflection5->getValue($obj));

        $propertyReflection6 = ReflectionProperty::factory('FSi\Reflection\Fixture\ClassA', 'publicProperty');
        $propertyReflection6->setValue($obj, 'baz');
        $this->assertAttributeEquals('baz', 'publicProperty', $obj);
        $this->assertEquals('baz', $propertyReflection6->getValue($obj));
    }

    public function testExceptionClass()
    {
        $this->setExpectedException('ReflectionException');
        $reflectionClass = new ReflectionClass('FSi\Reflection\Fixture\ClassA');
    }

    public function testExceptionProperty()
    {
        $this->setExpectedException('ReflectionException');
        $reflectionProperty = new ReflectionProperty('FSi\Reflection\Fixture\ClassA', 'protectedProperty');
    }

    public function testExceptionMethod()
    {
        $this->setExpectedException('ReflectionException');
        $reflectionMethod = new ReflectionMethod('FSi\Reflection\Fixture\ClassA', 'protectedMethod');
    }
}
