<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\Rector\Core\HttpKernel\RectorKernel;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScopere8e811afab72\Rector\Testing\TestingParser\TestingParser;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
abstract class AbstractNodeTypeResolverTest extends \_PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
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
        $this->bootKernel(\_PhpScopere8e811afab72\Rector\Core\HttpKernel\RectorKernel::class);
        $this->betterNodeFinder = $this->getService(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder::class);
        $this->testingParser = $this->getService(\_PhpScopere8e811afab72\Rector\Testing\TestingParser\TestingParser::class);
        $this->nodeTypeResolver = $this->getService(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver::class);
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
