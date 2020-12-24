<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Testing\TestingParser;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\Rector\Core\Configuration\Option;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Parser\Parser;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeScopeAndMetadataDecorator;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Parameter\ParameterProvider;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function __construct(\_PhpScopere8e811afab72\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Parser\Parser $parser, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeScopeAndMetadataDecorator $nodeScopeAndMetadataDecorator, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder)
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
        $smartFileInfo = new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo($file);
        $this->parameterProvider->changeParameter(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::SOURCE, [$file]);
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
