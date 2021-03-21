<?php

declare (strict_types=1);
namespace Symplify\SymfonyPhpConfig\Tests\ValueObjectInliner;

use Iterator;
use RectorPrefix20210321\PHPUnit\Framework\TestCase;
use RectorPrefix20210321\Symfony\Component\Config\FileLocator;
use RectorPrefix20210321\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20210321\Symfony\Component\DependencyInjection\Loader\Configurator\ReferenceConfigurator;
use RectorPrefix20210321\Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator;
use RectorPrefix20210321\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symplify\SymfonyPhpConfig\Tests\ValueObjectInliner\Source\SomeValueObject;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
final class InlineSingleObjectTest extends \RectorPrefix20210321\PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider provideData()
     * @param SomeValueObject $valueObject
     */
    public function test(object $valueObject, string $expectedType) : void
    {
        $servicesConfigurator = $this->createServiceConfigurator();
        $referenceConfigurator = \Symplify\SymfonyPhpConfig\ValueObjectInliner::inlineArgumentObject($valueObject, $servicesConfigurator);
        $this->assertInstanceOf(\RectorPrefix20210321\Symfony\Component\DependencyInjection\Loader\Configurator\ReferenceConfigurator::class, $referenceConfigurator);
        $id = (string) $referenceConfigurator;
        $this->assertSame($expectedType, $id);
    }
    /**
     * @return Iterator<class-string<SomeValueObject>[]|SomeValueObject[]>
     */
    public function provideData() : \Iterator
    {
        (yield [new \Symplify\SymfonyPhpConfig\Tests\ValueObjectInliner\Source\SomeValueObject('Rector'), \Symplify\SymfonyPhpConfig\Tests\ValueObjectInliner\Source\SomeValueObject::class]);
    }
    private function createServiceConfigurator() : \RectorPrefix20210321\Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator
    {
        $containerBuilder = new \RectorPrefix20210321\Symfony\Component\DependencyInjection\ContainerBuilder();
        $phpFileLoader = new \RectorPrefix20210321\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \RectorPrefix20210321\Symfony\Component\Config\FileLocator());
        $instanceOf = [];
        return new \RectorPrefix20210321\Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator($containerBuilder, $phpFileLoader, $instanceOf);
    }
}
