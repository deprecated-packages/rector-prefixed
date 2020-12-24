<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Testing\TestingParser;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\Rector\Core\Configuration\Option;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Parser\Parser;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeScopeAndMetadataDecorator;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Parameter\ParameterProvider;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class TestingParser
{
    /**
     * @var ParameterProvider
     */
    private $parameterProvider;
    /**
     * @var Parser
     */
    private $parser;
    /**
     * @var NodeScopeAndMetadataDecorator
     */
    private $nodeScopeAndMetadataDecorator;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    public function __construct(\_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Parser\Parser $parser, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeScopeAndMetadataDecorator $nodeScopeAndMetadataDecorator, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder)
    {
        $this->parameterProvider = $parameterProvider;
        $this->parser = $parser;
        $this->nodeScopeAndMetadataDecorator = $nodeScopeAndMetadataDecorator;
        $this->betterNodeFinder = $betterNodeFinder;
    }
    /**
     * @return Node[]
     */
    public function parseFileToDecoratedNodes(string $file) : array
    {
        // autoload file
        require_once $file;
        $smartFileInfo = new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo($file);
        $this->parameterProvider->changeParameter(\_PhpScoper0a6b37af0871\Rector\Core\Configuration\Option::SOURCE, [$file]);
        $nodes = $this->parser->parseFileInfo($smartFileInfo);
        return $this->nodeScopeAndMetadataDecorator->decorateNodesFromFile($nodes, $smartFileInfo);
    }
    /**
     * @return Node[]
     */
    public function parseFileToDecoratedNodesAndFindNodesByType(string $file, string $nodeClass) : array
    {
        $nodes = $this->parseFileToDecoratedNodes($file);
        return $this->betterNodeFinder->findInstanceOf($nodes, $nodeClass);
    }
}
