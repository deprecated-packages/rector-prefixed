<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\InheritDocMergingVar;

use function PHPStan\Analyser\assertType;
class A
{
}
class B extends \_PhpScopera143bcca66cb\InheritDocMergingVar\A
{
}
class One
{
    /** @var A */
    protected $property;
    public function method() : void
    {
        \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\InheritDocMergingVar\\A', $this->property);
    }
}
class Two extends \_PhpScopera143bcca66cb\InheritDocMergingVar\One
{
    /** @var B */
    protected $property;
    public function method() : void
    {
        \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\InheritDocMergingVar\\B', $this->property);
    }
}
class Three extends \_PhpScopera143bcca66cb\InheritDocMergingVar\Two
{
    /** Some comment */
    protected $property;
    public function method() : void
    {
        \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\InheritDocMergingVar\\B', $this->property);
    }
}
class Four extends \_PhpScopera143bcca66cb\InheritDocMergingVar\Three
{
    protected $property;
    public function method() : void
    {
        \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\InheritDocMergingVar\\B', $this->property);
    }
}
class Five extends \_PhpScopera143bcca66cb\InheritDocMergingVar\Four
{
    public function method() : void
    {
        \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\InheritDocMergingVar\\B', $this->property);
    }
}
class Six extends \_PhpScopera143bcca66cb\InheritDocMergingVar\Five
{
    protected $property;
    public function method() : void
    {
        \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\InheritDocMergingVar\\B', $this->property);
    }
}
class Seven extends \_PhpScopera143bcca66cb\InheritDocMergingVar\One
{
    /**
     * @inheritDoc
     * @var B
     */
    protected $property;
}
/**
 * @template T of object
 */
class ClassWithTemplate
{
    /** @var T */
    protected $prop;
}
class ChildClassExtendingClassWithTemplate extends \_PhpScopera143bcca66cb\InheritDocMergingVar\ClassWithTemplate
{
    protected $prop;
    public function doFoo()
    {
        \PHPStan\Analyser\assertType('object', $this->prop);
    }
}
/**
 * @extends ClassWithTemplate<\stdClass>
 */
class ChildClass2ExtendingClassWithTemplate extends \_PhpScopera143bcca66cb\InheritDocMergingVar\ClassWithTemplate
{
    /** someComment */
    protected $prop;
    public function doFoo()
    {
        \PHPStan\Analyser\assertType('stdClass', $this->prop);
    }
}
