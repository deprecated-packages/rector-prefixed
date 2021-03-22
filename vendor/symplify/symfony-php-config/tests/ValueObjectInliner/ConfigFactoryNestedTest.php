<?php

declare (strict_types=1);
namespace Symplify\SymfonyPhpConfig\Tests\ValueObjectInliner;

use PHPStan\Type\UnionType;
use RectorPrefix20210322\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use Symplify\SymfonyPhpConfig\Tests\HttpKernel\SymfonyPhpConfigKernel;
use Symplify\SymfonyPhpConfig\Tests\ValueObjectInliner\Source\ServiceWithValueObject;
use Symplify\SymfonyPhpConfig\Tests\ValueObjectInliner\Source\WithType;
final class ConfigFactoryNestedTest extends \RectorPrefix20210322\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    protected function setUp() : void
    {
        $this->bootKernelWithConfigs(\Symplify\SymfonyPhpConfig\Tests\HttpKernel\SymfonyPhpConfigKernel::class, [__DIR__ . '/config/config_with_nested_union_type_value_objects.php']);
    }
    public function testInlineValueObjectFunction() : void
    {
        /** @var ServiceWithValueObject $serviceWithValueObject */
        $serviceWithValueObject = $this->getService(\Symplify\SymfonyPhpConfig\Tests\ValueObjectInliner\Source\ServiceWithValueObject::class);
        $withType = $serviceWithValueObject->getWithType();
        $this->assertInstanceOf(\Symplify\SymfonyPhpConfig\Tests\ValueObjectInliner\Source\WithType::class, $withType);
        $this->assertInstanceOf(\PHPStan\Type\UnionType::class, $withType->getType());
    }
}
