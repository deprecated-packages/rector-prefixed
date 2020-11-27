<?php

declare (strict_types=1);
namespace Symplify\PackageBuilder\Tests\Reflection;

use _PhpScoper88fe6e0ad041\PHPUnit\Framework\TestCase;
use Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use Symplify\PackageBuilder\Tests\Reflection\Source\SomeClassWithPrivateProperty;
final class PrivatesAccessorTest extends \_PhpScoper88fe6e0ad041\PHPUnit\Framework\TestCase
{
    public function test() : void
    {
        $privatesAccessor = new \Symplify\PackageBuilder\Reflection\PrivatesAccessor();
        $someClassWithPrivateProperty = new \Symplify\PackageBuilder\Tests\Reflection\Source\SomeClassWithPrivateProperty();
        $this->assertSame($someClassWithPrivateProperty->getValue(), $privatesAccessor->getPrivateProperty($someClassWithPrivateProperty, 'value'));
        $this->assertSame($someClassWithPrivateProperty->getParentValue(), $privatesAccessor->getPrivateProperty($someClassWithPrivateProperty, 'parentValue'));
    }
}