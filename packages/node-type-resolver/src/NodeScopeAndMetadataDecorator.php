<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt;
use _PhpScoper0a2ac50786fa\PhpParser\NodeTraverser;
use _PhpScoper0a2ac50786fa\PhpParser\NodeVisitor\CloningVisitor;
use _PhpScoper0a2ac50786fa\PhpParser\NodeVisitor\NameResolver;
use _PhpScoper0a2ac50786fa\PhpParser\NodeVisitor\NodeConnectingVisitor;
use _PhpScoper0a2ac50786fa\Rector\Core\Configuration\Configuration;
use _PhpScoper0a2ac50786fa\Rector\NodeCollector\NodeVisitor\NodeCollectorNodeVisitor;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeVisitor\FileInfoNodeVisitor;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeVisitor\FirstLevelNodeVisitor;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeVisitor\FunctionLikeParamArgPositionNodeVisitor;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeVisitor\FunctionMethodAndClassNodeVisitor;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeVisitor\NamespaceNodeVisitor;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeVisitor\PhpDocInfoNodeVisitor;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeVisitor\StatementNodeVisitor;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\PHPStan\Scope\PHPStanNodeScopeResolver;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class NodeScopeAndMetadataDecorator
{
    /**
     * @var PHPStanNodeScopeResolver
     */
    private $phpStanNodeScopeResolver;
    /**
     * @var CloningVisitor
     */
    private $cloningVisitor;
    /**
     * @var FunctionMethodAndClassNodeVisitor
     */
    private $functionMethodAndClassNodeVisitor;
    /**
     * @var NamespaceNodeVisitor
     */
    private $namespaceNodeVisitor;
    /**
     * @var StatementNodeVisitor
     */
    private $statementNodeVisitor;
    /**
     * @var FileInfoNodeVisitor
     */
    private $fileInfoNodeVisitor;
    /**
     * @var NodeCollectorNodeVisitor
     */
    private $nodeCollectorNodeVisitor;
    /**
     * @var Configuration
     */
    private $configuration;
    /**
     * @var PhpDocInfoNodeVisitor
     */
    private $phpDocInfoNodeVisitor;
    /**
     * @var NodeConnectingVisitor
     */
    private $nodeConnectingVisitor;
    /**
     * @var FunctionLikeParamArgPositionNodeVisitor
     */
    private $functionLikeParamArgPositionNodeVisitor;
    /**
     * @var FirstLevelNodeVisitor
     */
    private $firstLevelNodeVisitor;
    public function __construct(\_PhpScoper0a2ac50786fa\PhpParser\NodeVisitor\CloningVisitor $cloningVisitor, \_PhpScoper0a2ac50786fa\Rector\Core\Configuration\Configuration $configuration, \_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeVisitor\FileInfoNodeVisitor $fileInfoNodeVisitor, \_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeVisitor\FunctionMethodAndClassNodeVisitor $functionMethodAndClassNodeVisitor, \_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeVisitor\NamespaceNodeVisitor $namespaceNodeVisitor, \_PhpScoper0a2ac50786fa\Rector\NodeCollector\NodeVisitor\NodeCollectorNodeVisitor $nodeCollectorNodeVisitor, \_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\PHPStan\Scope\PHPStanNodeScopeResolver $phpStanNodeScopeResolver, \_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeVisitor\PhpDocInfoNodeVisitor $phpDocInfoNodeVisitor, \_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeVisitor\StatementNodeVisitor $statementNodeVisitor, \_PhpScoper0a2ac50786fa\PhpParser\NodeVisitor\NodeConnectingVisitor $nodeConnectingVisitor, \_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeVisitor\FunctionLikeParamArgPositionNodeVisitor $functionLikeParamArgPositionNodeVisitor, \_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeVisitor\FirstLevelNodeVisitor $firstLevelNodeVisitor)
    {
        $this->phpStanNodeScopeResolver = $phpStanNodeScopeResolver;
        $this->cloningVisitor = $cloningVisitor;
        $this->functionMethodAndClassNodeVisitor = $functionMethodAndClassNodeVisitor;
        $this->namespaceNodeVisitor = $namespaceNodeVisitor;
        $this->statementNodeVisitor = $statementNodeVisitor;
        $this->fileInfoNodeVisitor = $fileInfoNodeVisitor;
        $this->nodeCollectorNodeVisitor = $nodeCollectorNodeVisitor;
        $this->configuration = $configuration;
        $this->phpDocInfoNodeVisitor = $phpDocInfoNodeVisitor;
        $this->nodeConnectingVisitor = $nodeConnectingVisitor;
        $this->functionLikeParamArgPositionNodeVisitor = $functionLikeParamArgPositionNodeVisitor;
        $this->firstLevelNodeVisitor = $firstLevelNodeVisitor;
    }
    /**
     * @param Node[] $nodes
     * @return Node[]
     */
    public function decorateNodesFromFile(array $nodes, \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, bool $needsScope = \false) : array
    {
        $nodeTraverser = new \_PhpScoper0a2ac50786fa\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor(new \_PhpScoper0a2ac50786fa\PhpParser\NodeVisitor\NameResolver(null, [
            'preserveOriginalNames' => \true,
            // required by PHPStan
            'replaceNodes' => \true,
        ]));
        $nodes = $nodeTraverser->traverse($nodes);
        // node scoping is needed only for Scope
        if ($needsScope || $this->configuration->areAnyPhpRectorsLoaded()) {
            $nodes = $this->phpStanNodeScopeResolver->processNodes($nodes, $smartFileInfo);
        }
        $nodeTraverser = new \_PhpScoper0a2ac50786fa\PhpParser\NodeTraverser();
        $preservingNameResolver = new \_PhpScoper0a2ac50786fa\PhpParser\NodeVisitor\NameResolver(null, [
            'preserveOriginalNames' => \true,
            // this option would override old non-fqn-namespaced nodes otherwise, so it needs to be disabled
            'replaceNodes' => \false,
        ]);
        $nodeTraverser->addVisitor($preservingNameResolver);
        $nodes = $nodeTraverser->traverse($nodes);
        $nodeTraverser = new \_PhpScoper0a2ac50786fa\PhpParser\NodeTraverser();
        // needed also for format preserving printing
        $nodeTraverser->addVisitor($this->cloningVisitor);
        $nodeTraverser->addVisitor($this->nodeConnectingVisitor);
        $nodeTraverser->addVisitor($this->functionMethodAndClassNodeVisitor);
        $nodeTraverser->addVisitor($this->namespaceNodeVisitor);
        $nodeTraverser->addVisitor($this->phpDocInfoNodeVisitor);
        $nodeTraverser->addVisitor($this->firstLevelNodeVisitor);
        $nodeTraverser->addVisitor($this->functionLikeParamArgPositionNodeVisitor);
        $nodes = $nodeTraverser->traverse($nodes);
        // this split is needed, so nodes have names, classes and namespaces
        $nodeTraverser = new \_PhpScoper0a2ac50786fa\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor($this->statementNodeVisitor);
        $nodeTraverser->addVisitor($this->fileInfoNodeVisitor);
        $nodeTraverser->addVisitor($this->nodeCollectorNodeVisitor);
        return $nodeTraverser->traverse($nodes);
    }
    /**
     * @param Stmt[] $nodes
     * @return Stmt[]
     */
    public function decorateNodesFromString(array $nodes) : array
    {
        $nodeTraverser = new \_PhpScoper0a2ac50786fa\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor($this->nodeConnectingVisitor);
        $nodeTraverser->addVisitor($this->functionMethodAndClassNodeVisitor);
        $nodeTraverser->addVisitor($this->statementNodeVisitor);
        return $nodeTraverser->traverse($nodes);
    }
}
