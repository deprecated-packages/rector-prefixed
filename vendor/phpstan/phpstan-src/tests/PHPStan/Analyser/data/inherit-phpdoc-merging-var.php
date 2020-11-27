<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\InheritDocMergingVar;

use function PHPStan\Analyser\assertType;
class A
{
}
class B extends \_PhpScoper88fe6e0ad041\InheritDocMergingVar\A
{
}
class One
{
    /** @var A */
    protected $property;
    public function method() : void
    {
        \PHPStan\Analyser\assertType('_PhpScoper88fe6e0ad041\\InheritDocMergingVar\\A', $this->property);
    }
}
class Two extends \_PhpScoper88fe6e0ad041\InheritDocMergingVar\One
{
    /** @var B */
    protected $property;
    public function method() : void
    {
        \PHPStan\Analyser\assertType('_PhpScoper88fe6e0ad041\\InheritDocMergingVar\\B', $this->property);
    }
}
class Three extends \_PhpScoper88fe6e0ad041\InheritDocMergingVar\Two
{
    /** Some comment */
    protected $property;
    public function method() : void
    {
        \PHPStan\Analyser\assertType('_PhpScoper88fe6e0ad041\\InheritDocMergingVar\\B', $this->property);
    }
}
class Four extends \_PhpScoper88fe6e0ad041\InheritDocMergingVar\Three
{
    protected $property;
    public function method() : void
    {
        \PHPStan\Analyser\assertType('_PhpScoper88fe6e0ad041\\InheritDocMergingVar\\B', $this->property);
    }
}
class Five extends \_PhpScoper88fe6e0ad041\InheritDocMergingVar\Four
{
    public function method() : void
    {
        \PHPStan\Analyser\assertType('_PhpScoper88fe6e0ad041\\InheritDocMergingVar\\B', $this->property);
    }
}
class Six extends \_PhpScoper88fe6e0ad041\InheritDocMergingVar\Five
{
    protected $property;
    public function method() : void
    {
        \PHPStan\Analyser\assertType('_PhpScoper88fe6e0ad041\\InheritDocMergingVar\\B', $this->property);
    }
}
class Seven extends \_PhpScoper88fe6e0ad041\InheritDocMergingVar\One
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
class ChildClassExtendingClassWithTemplate extends \_PhpScoper88fe6e0ad041\InheritDocMergingVar\ClassWithTemplate
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
class ChildClass2ExtendingClassWithTemplate extends \_PhpScoper88fe6e0ad041\InheritDocMergingVar\ClassWithTemplate
{
    /** someComment */
    protected $prop;
    public function doFoo()
    {
        \PHPStan\Analyser\assertType('stdClass', $this->prop);
    }
}