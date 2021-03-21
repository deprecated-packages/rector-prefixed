<?php

declare (strict_types=1);
namespace RectorPrefix20210321\Symplify\PackageBuilder\Tests\Reflection;

use RectorPrefix20210321\PHPUnit\Framework\TestCase;
use RectorPrefix20210321\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use RectorPrefix20210321\Symplify\PackageBuilder\Tests\Reflection\Source\SomeClassWithPrivateProperty;
final class PrivatesAccessorTest extends \RectorPrefix20210321\PHPUnit\Framework\TestCase
{
    public function test() : void
    {
        $privatesAccessor = new \RectorPrefix20210321\Symplify\PackageBuilder\Reflection\PrivatesAccessor();
        $someClassWithPrivateProperty = new \RectorPrefix20210321\Symplify\PackageBuilder\Tests\Reflection\Source\SomeClassWithPrivateProperty();
        $fetchedValue = $privatesAccessor->getPrivateProperty($someClassWithPrivateProperty, 'value');
        $this->assertSame($someClassWithPrivateProperty->getValue(), $fetchedValue);
        $fetchedParentValue = $privatesAccessor->getPrivateProperty($someClassWithPrivateProperty, 'parentValue');
        $this->assertSame($someClassWithPrivateProperty->getParentValue(), $fetchedParentValue);
    }
}
