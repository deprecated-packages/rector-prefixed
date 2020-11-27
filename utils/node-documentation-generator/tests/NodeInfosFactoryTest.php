<?php

declare (strict_types=1);
namespace Rector\Utils\NodeDocumentationGenerator\Tests;

use Rector\Core\HttpKernel\RectorKernel;
use Rector\Utils\NodeDocumentationGenerator\NodeInfosFactory;
use Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class NodeInfosFactoryTest extends \Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var NodeInfosFactory
     */
    private $nodeInfosFactory;
    protected function setUp() : void
    {
        $this->bootKernel(\Rector\Core\HttpKernel\RectorKernel::class);
        $this->nodeInfosFactory = self::$container->get(\Rector\Utils\NodeDocumentationGenerator\NodeInfosFactory::class);
    }
    public function test() : void
    {
        $nodeInfos = $this->nodeInfosFactory->create();
        $nodeInfoCount = \count($nodeInfos);
        $this->assertGreaterThan(50, $nodeInfoCount);
    }
}
