<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\Rector\Core\HttpKernel\RectorKernel;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScoperb75b35f52b74\Rector\Testing\TestingParser\TestingParser;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
abstract class AbstractNodeTypeResolverTest extends \_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
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
        $this->bootKernel(\_PhpScoperb75b35f52b74\Rector\Core\HttpKernel\RectorKernel::class);
        $this->betterNodeFinder = $this->getService(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder::class);
        $this->testingParser = $this->getService(\_PhpScoperb75b35f52b74\Rector\Testing\TestingParser\TestingParser::class);
        $this->nodeTypeResolver = $this->getService(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver::class);
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
