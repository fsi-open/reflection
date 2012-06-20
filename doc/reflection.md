# Reflection - Optimized reflection package for PHP 5.3

**FSi\Reflection** is an extension of built-in reflection classes in PHP 5.3. Some of their methods are rewritten in such way
that reflection objects are cached and never created twice for the same class/method/property/function or extension. This is
achieved by usage of factory pattern. Some of the methods that cannot be rewriten to use such a cache throw an exception. All
ReflectionProperty and ReflectionMethod objects returned from this library are previously set as accessible so they can be used
even if they're private or protected.

Content:

- [including extension](#including)
- [usage example](#example)

## Setup and autoloading {#including}

If you are using the official extension repository, initial directory structure for 
the library should look like this:

    ...
    /Reflection
        /bin
        /doc
        /lib
            /FSi
                /Reflection
                    ...
        /tests
            ...
    ...

First of all we need to setup the autoloading of required extensions:

    $classLoader = new \Doctrine\Common\ClassLoader('FSi\\Reflection', "/path/to/library/Reflection/lib");
    $classLoader->register();

## Usage example {#example}

The key idea of using this reflection library is not to contruct reflection classes by their constuctors but through the factory()
methods added to each reflection class. Let's assume we have a class named ClassA:

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

In order to create reflection objects you can:

    use FSi\Reflection;
    
    $reflectionClassA = ReflectionClass::factory('ClassA');
    $reflectionPropertyPrivate = $reflectionClassA->getProperty('privateProperty');
    $reflectionPropertyPrivate = ReflectionProperty::factory('ClassA', 'privateProperty');
    $reflectionMethodPrivate = $reflectionClassA->getMethod('privateMethod');
    $reflectionMethodPrivate = ReflectionMethod::factory('ClassA', 'privateMethod');

You must remember that using any reflection class' constructor directly in your code will throw an exception.

