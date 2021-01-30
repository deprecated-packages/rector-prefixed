<?php

declare (strict_types=1);
namespace RectorPrefix20210130\Symplify\PackageBuilder\Tests\Parameter;

use RectorPrefix20210130\Symplify\PackageBuilder\Parameter\ParameterProvider;
use RectorPrefix20210130\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use RectorPrefix20210130\Symplify\PackageBuilder\Tests\HttpKernel\PackageBuilderTestKernel;
final class ParameterProviderTest extends \RectorPrefix20210130\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    public function test() : void
    {
        $this->bootKernelWithConfigs(\RectorPrefix20210130\Symplify\PackageBuilder\Tests\HttpKernel\PackageBuilderTestKernel::class, [__DIR__ . '/ParameterProviderSource/config.yml']);
        $parameterProvider = $this->getService(\RectorPrefix20210130\Symplify\PackageBuilder\Parameter\ParameterProvider::class);
        $parameters = $parameterProvider->provide();
        $this->assertArrayHasKey('key', $parameters);
        $this->assertArrayHasKey('camelCase', $parameters);
        $this->assertArrayHasKey('pascal_case', $parameters);
        $this->assertSame('value', $parameters['key']);
        $this->assertSame('Lion', $parameters['camelCase']);
        $this->assertSame('Celsius', $parameters['pascal_case']);
        $keyParameter = $parameterProvider->provideParameter('key');
        $this->assertSame('value', $keyParameter);
        $parameterProvider->changeParameter('key', 'anotherKey');
        $keyParameter = $parameterProvider->provideParameter('key');
        $this->assertSame('anotherKey', $keyParameter);
    }
    public function testIncludingYaml() : void
    {
        $this->bootKernelWithConfigs(\RectorPrefix20210130\Symplify\PackageBuilder\Tests\HttpKernel\PackageBuilderTestKernel::class, [__DIR__ . '/ParameterProviderSource/Yaml/including-config.php']);
        $parameterProvider = $this->getService(\RectorPrefix20210130\Symplify\PackageBuilder\Parameter\ParameterProvider::class);
        $parameters = $parameterProvider->provide();
        $this->assertArrayHasKey('one', $parameters);
        $this->assertArrayHasKey('two', $parameters);
        $this->assertSame(1, $parameters['one']);
        $this->assertSame(2, $parameters['two']);
        $this->assertArrayHasKey('kernel.project_dir', $parameterProvider->provide());
    }
}
