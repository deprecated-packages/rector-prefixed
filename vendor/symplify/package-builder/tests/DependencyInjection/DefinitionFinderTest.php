<?php

declare (strict_types=1);
namespace Symplify\PackageBuilder\Tests\DependencyInjection;

use _PhpScoperbd5d0c5f7638\PHPUnit\Framework\TestCase;
use stdClass;
use _PhpScoperbd5d0c5f7638\Symfony\Component\DependencyInjection\ContainerBuilder;
use Symplify\PackageBuilder\DependencyInjection\DefinitionFinder;
use Symplify\PackageBuilder\Exception\DependencyInjection\DefinitionForTypeNotFoundException;
final class DefinitionFinderTest extends \_PhpScoperbd5d0c5f7638\PHPUnit\Framework\TestCase
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
        $this->containerBuilder = new \_PhpScoperbd5d0c5f7638\Symfony\Component\DependencyInjection\ContainerBuilder();
        $this->definitionFinder = new \Symplify\PackageBuilder\DependencyInjection\DefinitionFinder();
    }
    public function testAutowired() : void
    {
        $definition = $this->containerBuilder->autowire(\stdClass::class);
        $this->assertSame($definition, $this->definitionFinder->getByType($this->containerBuilder, \stdClass::class));
    }
    public function testNonAutowired() : void
    {
        $definition = $this->containerBuilder->register(\stdClass::class);
        $this->assertSame($definition, $this->definitionFinder->getByType($this->containerBuilder, \stdClass::class));
    }
    public function testMissing() : void
    {
        $this->expectException(\Symplify\PackageBuilder\Exception\DependencyInjection\DefinitionForTypeNotFoundException::class);
        $this->definitionFinder->getByType($this->containerBuilder, \stdClass::class);
    }
}
