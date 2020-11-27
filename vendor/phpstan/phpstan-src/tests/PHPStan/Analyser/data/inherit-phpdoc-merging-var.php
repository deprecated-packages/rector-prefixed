<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\InheritDocMergingVar;

use function PHPStan\Analyser\assertType;
class A
{
}
class B extends \_PhpScoperbd5d0c5f7638\InheritDocMergingVar\A
{
}
class One
{
    /** @var A */
    protected $property;
    public function method() : void
    {
        \PHPStan\Analyser\assertType('_PhpScoperbd5d0c5f7638\\InheritDocMergingVar\\A', $this->property);
    }
}
class Two extends \_PhpScoperbd5d0c5f7638\InheritDocMergingVar\One
{
    /** @var B */
    protected $property;
    public function method() : void
    {
        \PHPStan\Analyser\assertType('_PhpScoperbd5d0c5f7638\\InheritDocMergingVar\\B', $this->property);
    }
}
class Three extends \_PhpScoperbd5d0c5f7638\InheritDocMergingVar\Two
{
    /** Some comment */
    protected $property;
    public function method() : void
    {
        \PHPStan\Analyser\assertType('_PhpScoperbd5d0c5f7638\\InheritDocMergingVar\\B', $this->property);
    }
}
class Four extends \_PhpScoperbd5d0c5f7638\InheritDocMergingVar\Three
{
    protected $property;
    public function method() : void
    {
        \PHPStan\Analyser\assertType('_PhpScoperbd5d0c5f7638\\InheritDocMergingVar\\B', $this->property);
    }
}
class Five extends \_PhpScoperbd5d0c5f7638\InheritDocMergingVar\Four
{
    public function method() : void
    {
        \PHPStan\Analyser\assertType('_PhpScoperbd5d0c5f7638\\InheritDocMergingVar\\B', $this->property);
    }
}
class Six extends \_PhpScoperbd5d0c5f7638\InheritDocMergingVar\Five
{
    protected $property;
    public function method() : void
    {
        \PHPStan\Analyser\assertType('_PhpScoperbd5d0c5f7638\\InheritDocMergingVar\\B', $this->property);
    }
}
class Seven extends \_PhpScoperbd5d0c5f7638\InheritDocMergingVar\One
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
class ChildClassExtendingClassWithTemplate extends \_PhpScoperbd5d0c5f7638\InheritDocMergingVar\ClassWithTemplate
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
class ChildClass2ExtendingClassWithTemplate extends \_PhpScoperbd5d0c5f7638\InheritDocMergingVar\ClassWithTemplate
{
    /** someComment */
    protected $prop;
    public function doFoo()
    {
        \PHPStan\Analyser\assertType('stdClass', $this->prop);
    }
}
