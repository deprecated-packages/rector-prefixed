<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt;
use _PhpScoperb75b35f52b74\PhpParser\NodeTraverser;
use _PhpScoperb75b35f52b74\PhpParser\NodeVisitor\CloningVisitor;
use _PhpScoperb75b35f52b74\PhpParser\NodeVisitor\NameResolver;
use _PhpScoperb75b35f52b74\PhpParser\NodeVisitor\NodeConnectingVisitor;
use _PhpScoperb75b35f52b74\Rector\Core\Configuration\Configuration;
use _PhpScoperb75b35f52b74\Rector\NodeCollector\NodeVisitor\NodeCollectorNodeVisitor;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeVisitor\FileInfoNodeVisitor;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeVisitor\FirstLevelNodeVisitor;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeVisitor\FunctionLikeParamArgPositionNodeVisitor;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeVisitor\FunctionMethodAndClassNodeVisitor;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeVisitor\NamespaceNodeVisitor;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeVisitor\PhpDocInfoNodeVisitor;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeVisitor\StatementNodeVisitor;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\PHPStan\Scope\PHPStanNodeScopeResolver;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\NodeVisitor\CloningVisitor $cloningVisitor, \_PhpScoperb75b35f52b74\Rector\Core\Configuration\Configuration $configuration, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeVisitor\FileInfoNodeVisitor $fileInfoNodeVisitor, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeVisitor\FunctionMethodAndClassNodeVisitor $functionMethodAndClassNodeVisitor, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeVisitor\NamespaceNodeVisitor $namespaceNodeVisitor, \_PhpScoperb75b35f52b74\Rector\NodeCollector\NodeVisitor\NodeCollectorNodeVisitor $nodeCollectorNodeVisitor, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\PHPStan\Scope\PHPStanNodeScopeResolver $phpStanNodeScopeResolver, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeVisitor\PhpDocInfoNodeVisitor $phpDocInfoNodeVisitor, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeVisitor\StatementNodeVisitor $statementNodeVisitor, \_PhpScoperb75b35f52b74\PhpParser\NodeVisitor\NodeConnectingVisitor $nodeConnectingVisitor, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeVisitor\FunctionLikeParamArgPositionNodeVisitor $functionLikeParamArgPositionNodeVisitor, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeVisitor\FirstLevelNodeVisitor $firstLevelNodeVisitor)
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
    public function decorateNodesFromFile(array $nodes, \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, bool $needsScope = \false) : array
    {
        $nodeTraverser = new \_PhpScoperb75b35f52b74\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor(new \_PhpScoperb75b35f52b74\PhpParser\NodeVisitor\NameResolver(null, [
            'preserveOriginalNames' => \true,
            // required by PHPStan
            'replaceNodes' => \true,
        ]));
        $nodes = $nodeTraverser->traverse($nodes);
        // node scoping is needed only for Scope
        if ($needsScope || $this->configuration->areAnyPhpRectorsLoaded()) {
            $nodes = $this->phpStanNodeScopeResolver->processNodes($nodes, $smartFileInfo);
        }
        $nodeTraverser = new \_PhpScoperb75b35f52b74\PhpParser\NodeTraverser();
        $preservingNameResolver = new \_PhpScoperb75b35f52b74\PhpParser\NodeVisitor\NameResolver(null, [
            'preserveOriginalNames' => \true,
            // this option would override old non-fqn-namespaced nodes otherwise, so it needs to be disabled
            'replaceNodes' => \false,
        ]);
        $nodeTraverser->addVisitor($preservingNameResolver);
        $nodes = $nodeTraverser->traverse($nodes);
        $nodeTraverser = new \_PhpScoperb75b35f52b74\PhpParser\NodeTraverser();
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
        $nodeTraverser = new \_PhpScoperb75b35f52b74\PhpParser\NodeTraverser();
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
        $nodeTraverser = new \_PhpScoperb75b35f52b74\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor($this->nodeConnectingVisitor);
        $nodeTraverser->addVisitor($this->functionMethodAndClassNodeVisitor);
        $nodeTraverser->addVisitor($this->statementNodeVisitor);
        return $nodeTraverser->traverse($nodes);
    }
}
