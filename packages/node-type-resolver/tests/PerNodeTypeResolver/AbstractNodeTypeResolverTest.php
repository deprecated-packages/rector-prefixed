<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\Rector\Core\HttpKernel\RectorKernel;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScoper0a6b37af0871\Rector\Testing\TestingParser\TestingParser;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
abstract class AbstractNodeTypeResolverTest extends \_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var NodeTypeResolver
     */
    protected $nodeTypeResolver;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var TestingParser
     */
    private $testingParser;
    protected function setUp() : void
    {
        $this->bootKernel(\_PhpScoper0a6b37af0871\Rector\Core\HttpKernel\RectorKernel::class);
        $this->betterNodeFinder = $this->getService(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\BetterNodeFinder::class);
        $this->testingParser = $this->getService(\_PhpScoper0a6b37af0871\Rector\Testing\TestingParser\TestingParser::class);
        $this->nodeTypeResolver = $this->getService(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver::class);
    }
    /**
     * @return Node[]
     */
    protected function getNodesForFileOfType(string $file, string $type) : array
    {
        $nodes = $this->testingParser->parseFileToDecoratedNodes($file);
        return $this->betterNodeFinder->findInstanceOf($nodes, $type);
    }
}
