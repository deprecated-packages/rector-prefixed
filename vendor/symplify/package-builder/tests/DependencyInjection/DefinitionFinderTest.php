<?php

declare (strict_types=1);
namespace RectorPrefix20210129\Symplify\PackageBuilder\Tests\DependencyInjection;

use RectorPrefix20210129\PHPUnit\Framework\TestCase;
use stdClass;
use RectorPrefix20210129\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20210129\Symplify\PackageBuilder\DependencyInjection\DefinitionFinder;
use RectorPrefix20210129\Symplify\PackageBuilder\Exception\DependencyInjection\DefinitionForTypeNotFoundException;
final class DefinitionFinderTest extends \RectorPrefix20210129\PHPUnit\Framework\TestCase
{
    /**
     * @var ContainerBuilder
     */
    private $containerBuilder;
    /**
     * @var DefinitionFinder
     */
    private $definitionFinder;
    protected function setUp() : void
    {
        $this->containerBuilder = new \RectorPrefix20210129\Symfony\Component\DependencyInjection\ContainerBuilder();
        $this->definitionFinder = new \RectorPrefix20210129\Symplify\PackageBuilder\DependencyInjection\DefinitionFinder();
    }
    public function testAutowired() : void
    {
        $definition = $this->containerBuilder->autowire(\stdClass::class);
        $stdClassDefinition = $this->definitionFinder->getByType($this->containerBuilder, \stdClass::class);
        $this->assertSame($definition, $stdClassDefinition);
    }
    public function testNonAutowired() : void
    {
        $definition = $this->containerBuilder->register(\stdClass::class);
        $foundStdClass = $this->definitionFinder->getByType($this->containerBuilder, \stdClass::class);
        $this->assertSame($definition, $foundStdClass);
    }
    public function testMissing() : void
    {
        $this->expectException(\RectorPrefix20210129\Symplify\PackageBuilder\Exception\DependencyInjection\DefinitionForTypeNotFoundException::class);
        $this->definitionFinder->getByType($this->containerBuilder, \stdClass::class);
    }
}
