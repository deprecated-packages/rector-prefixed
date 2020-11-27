<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\InheritDocMergingVar;

use function PHPStan\Analyser\assertType;
class A
{
}
class B extends \_PhpScoper26e51eeacccf\InheritDocMergingVar\A
{
}
class One
{
    /** @var A */
    protected $property;
    public function method() : void
    {
        \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InheritDocMergingVar\\A', $this->property);
    }
}
class Two extends \_PhpScoper26e51eeacccf\InheritDocMergingVar\One
{
    /** @var B */
    protected $property;
    public function method() : void
    {
        \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InheritDocMergingVar\\B', $this->property);
    }
}
class Three extends \_PhpScoper26e51eeacccf\InheritDocMergingVar\Two
{
    /** Some comment */
    protected $property;
    public function method() : void
    {
        \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InheritDocMergingVar\\B', $this->property);
    }
}
class Four extends \_PhpScoper26e51eeacccf\InheritDocMergingVar\Three
{
    protected $property;
    public function method() : void
    {
        \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InheritDocMergingVar\\B', $this->property);
    }
}
class Five extends \_PhpScoper26e51eeacccf\InheritDocMergingVar\Four
{
    public function method() : void
    {
        \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InheritDocMergingVar\\B', $this->property);
    }
}
class Six extends \_PhpScoper26e51eeacccf\InheritDocMergingVar\Five
{
    protected $property;
    public function method() : void
    {
        \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InheritDocMergingVar\\B', $this->property);
    }
}
class Seven extends \_PhpScoper26e51eeacccf\InheritDocMergingVar\One
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
class ChildClassExtendingClassWithTemplate extends \_PhpScoper26e51eeacccf\InheritDocMergingVar\ClassWithTemplate
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
class ChildClass2ExtendingClassWithTemplate extends \_PhpScoper26e51eeacccf\InheritDocMergingVar\ClassWithTemplate
{
    /** someComment */
    protected $prop;
    public function doFoo()
    {
        \PHPStan\Analyser\assertType('stdClass', $this->prop);
    }
}
