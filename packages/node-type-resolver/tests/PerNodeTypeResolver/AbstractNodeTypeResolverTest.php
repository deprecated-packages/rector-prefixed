<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\Rector\Core\HttpKernel\RectorKernel;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScoper0a2ac50786fa\Rector\Testing\TestingParser\TestingParser;
use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
abstract class AbstractNodeTypeResolverTest extends \_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
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
        $this->bootKernel(\_PhpScoper0a2ac50786fa\Rector\Core\HttpKernel\RectorKernel::class);
        $this->betterNodeFinder = self::$container->get(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\BetterNodeFinder::class);
        $this->testingParser = self::$container->get(\_PhpScoper0a2ac50786fa\Rector\Testing\TestingParser\TestingParser::class);
        $this->nodeTypeResolver = self::$container->get(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeTypeResolver::class);
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
