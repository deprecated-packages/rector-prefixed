<?php

declare (strict_types=1);
namespace Rector\Core\Rector;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Function_;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\ParentConnectingVisitor;
use PhpParser\NodeVisitorAbstract;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\ChangesReporting\Collector\RectorChangeCollector;
use Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector;
use Rector\Core\Configuration\CurrentNodeProvider;
use Rector\Core\Configuration\Option;
use Rector\Core\Contract\Rector\PhpRectorInterface;
use Rector\Core\Exclusion\ExclusionManager;
use Rector\Core\Logging\CurrentRectorProvider;
use Rector\Core\NodeAnalyzer\ClassAnalyzer;
use Rector\Core\Php\PhpVersionProvider;
use Rector\Core\PhpParser\Comparing\NodeComparator;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\Core\PhpParser\Node\NodeFactory;
use Rector\Core\PhpParser\Node\Value\ValueResolver;
use Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use Rector\Core\ValueObject\ProjectType;
use Rector\NodeCollector\NodeCollector\NodeRepository;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeRemoval\NodeRemover;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\NodeTypeResolver;
use Rector\PostRector\Collector\NodesToAddCollector;
use Rector\PostRector\Collector\NodesToRemoveCollector;
use Rector\PostRector\DependencyInjection\PropertyAdder;
use Rector\Privatization\NodeManipulator\VisibilityManipulator;
use Rector\StaticTypeMapper\StaticTypeMapper;
use RectorPrefix20210408\Symfony\Component\Console\Style\SymfonyStyle;
use RectorPrefix20210408\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
use RectorPrefix20210408\Symplify\PackageBuilder\Parameter\ParameterProvider;
use RectorPrefix20210408\Symplify\Skipper\Skipper\Skipper;
use RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Rector\Testing\PHPUnit\AbstractRectorTestCase
 */
abstract class AbstractRector extends \PhpParser\NodeVisitorAbstract implements \Rector\Core\Contract\Rector\PhpRectorInterface
{
    /**
     * @var string[]
     */
    private const ATTRIBUTES_TO_MIRROR = [\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, \Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE, \Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME, \Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO, \Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE, \Rector\NodeTypeResolver\Node\AttributeKey::USE_NODES, \Rector\NodeTypeResolver\Node\AttributeKey::SCOPE, \Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME, \Rector\NodeTypeResolver\Node\AttributeKey::RESOLVED_NAME];
    /**
     * @var NodeNameResolver
     */
    protected $nodeNameResolver;
    /**
     * @var NodeTypeResolver
     */
    protected $nodeTypeResolver;
    /**
     * @var BetterStandardPrinter
     */
    protected $betterStandardPrinter;
    /**
     * @var RemovedAndAddedFilesCollector
     */
    protected $removedAndAddedFilesCollector;
    /**
     * @var ParameterProvider
     */
    protected $parameterProvider;
    /**
     * @var PhpVersionProvider
     */
    protected $phpVersionProvider;
    /**
     * @var StaticTypeMapper
     */
    protected $staticTypeMapper;
    /**
     * @var PhpDocInfoFactory
     */
    protected $phpDocInfoFactory;
    /**
     * @var NodeFactory
     */
    protected $nodeFactory;
    /**
     * @var VisibilityManipulator
     */
    protected $visibilityManipulator;
    /**
     * @var ValueResolver
     */
    protected $valueResolver;
    /**
     * @var NodeRepository
     */
    protected $nodeRepository;
    /**
     * @var BetterNodeFinder
     */
    protected $betterNodeFinder;
    /**
     * @var ClassAnalyzer
     */
    protected $classAnalyzer;
    /**
     * @var NodeRemover
     */
    protected $nodeRemover;
    /**
     * @var RectorChangeCollector
     */
    protected $rectorChangeCollector;
    /**
     * @var NodeComparator
     */
    protected $nodeComparator;
    /**
     * @var PropertyAdder
     */
    protected $propertyAdder;
    /**
     * @var NodesToRemoveCollector
     */
    protected $nodesToRemoveCollector;
    /**
     * @var SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;
    /**
     * @var ExclusionManager
     */
    private $exclusionManager;
    /**
     * @var CurrentRectorProvider
     */
    private $currentRectorProvider;
    /**
     * @var CurrentNodeProvider
     */
    private $currentNodeProvider;
    /**
     * @var Skipper
     */
    private $skipper;
    /**
     * @var string|null
     */
    private $previousAppliedClass;
    /**
     * @var NodesToAddCollector
     */
    private $nodesToAddCollector;
    /**
     * @required
     */
    public function autowireAbstractRector(\Rector\PostRector\Collector\NodesToRemoveCollector $nodesToRemoveCollector, \Rector\PostRector\Collector\NodesToAddCollector $nodesToAddCollector, \Rector\ChangesReporting\Collector\RectorChangeCollector $rectorChangeCollector, \Rector\NodeRemoval\NodeRemover $nodeRemover, \Rector\PostRector\DependencyInjection\PropertyAdder $propertyAdder, \Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector $removedAndAddedFilesCollector, \Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \RectorPrefix20210408\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser $simpleCallableNodeTraverser, \Rector\Privatization\NodeManipulator\VisibilityManipulator $visibilityManipulator, \Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory, \RectorPrefix20210408\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \Rector\Core\Php\PhpVersionProvider $phpVersionProvider, \Rector\Core\Exclusion\ExclusionManager $exclusionManager, \Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \RectorPrefix20210408\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \Rector\Core\Logging\CurrentRectorProvider $currentRectorProvider, \Rector\Core\NodeAnalyzer\ClassAnalyzer $classAnalyzer, \Rector\Core\Configuration\CurrentNodeProvider $currentNodeProvider, \RectorPrefix20210408\Symplify\Skipper\Skipper\Skipper $skipper, \Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver, \Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository, \Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \Rector\Core\PhpParser\Comparing\NodeComparator $nodeComparator) : void
    {
        $this->nodesToRemoveCollector = $nodesToRemoveCollector;
        $this->nodesToAddCollector = $nodesToAddCollector;
        $this->rectorChangeCollector = $rectorChangeCollector;
        $this->nodeRemover = $nodeRemover;
        $this->propertyAdder = $propertyAdder;
        $this->removedAndAddedFilesCollector = $removedAndAddedFilesCollector;
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
        $this->visibilityManipulator = $visibilityManipulator;
        $this->nodeFactory = $nodeFactory;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
        $this->symfonyStyle = $symfonyStyle;
        $this->phpVersionProvider = $phpVersionProvider;
        $this->exclusionManager = $exclusionManager;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->parameterProvider = $parameterProvider;
        $this->currentRectorProvider = $currentRectorProvider;
        $this->classAnalyzer = $classAnalyzer;
        $this->currentNodeProvider = $currentNodeProvider;
        $this->skipper = $skipper;
        $this->valueResolver = $valueResolver;
        $this->nodeRepository = $nodeRepository;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeComparator = $nodeComparator;
    }
    /**
     * @return Node[]|null
     */
    public function beforeTraverse(array $nodes) : ?array
    {
        $this->previousAppliedClass = null;
        return parent::beforeTraverse($nodes);
    }
    /**
     * @return Expression|Node|null
     */
    public final function enterNode(\PhpParser\Node $node)
    {
        $nodeClass = \get_class($node);
        if (!$this->isMatchingNodeType($nodeClass)) {
            return null;
        }
        $this->currentRectorProvider->changeCurrentRector($this);
        // for PHP doc info factory and change notifier
        $this->currentNodeProvider->setNode($node);
        // already removed
        if ($this->shouldSkipCurrentNode($node)) {
            return null;
        }
        // show current Rector class on --debug
        $this->printDebugApplying();
        $originalNode = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE) ?? clone $node;
        $originalNodeWithAttributes = clone $node;
        $node = $this->refactor($node);
        // nothing to change → continue
        if (!$node instanceof \PhpParser\Node) {
            return null;
        }
        // changed!
        if ($this->hasNodeChanged($originalNode, $node)) {
            $this->updateAttributes($node);
            $this->keepFileInfoAttribute($node, $originalNode);
            $this->rectorChangeCollector->notifyNodeFileInfo($node);
            // update parents relations
            $nodeTraverser = new \PhpParser\NodeTraverser();
            $nodeTraverser->addVisitor(new \PhpParser\NodeVisitor\ParentConnectingVisitor());
            $nodeTraverser->traverse([$node]);
            $this->mirrorAttributes($originalNodeWithAttributes, $node);
        }
        // if stmt ("$value;") was replaced by expr ("$value"), add the ending ";" (Expression) to prevent breaking the code
        if ($originalNode instanceof \PhpParser\Node\Stmt && $node instanceof \PhpParser\Node\Expr) {
            return new \PhpParser\Node\Stmt\Expression($node);
        }
        return $node;
    }
    protected function isName(\PhpParser\Node $node, string $name) : bool
    {
        return $this->nodeNameResolver->isName($node, $name);
    }
    /**
     * @param string[] $names
     */
    protected function isNames(\PhpParser\Node $node, array $names) : bool
    {
        return $this->nodeNameResolver->isNames($node, $names);
    }
    protected function getName(\PhpParser\Node $node) : ?string
    {
        return $this->nodeNameResolver->getName($node);
    }
    protected function isObjectType(\PhpParser\Node $node, \PHPStan\Type\ObjectType $objectType) : bool
    {
        return $this->nodeTypeResolver->isObjectType($node, $objectType);
    }
    protected function getStaticType(\PhpParser\Node $node) : \PHPStan\Type\Type
    {
        return $this->nodeTypeResolver->getStaticType($node);
    }
    /**
     * @deprecated
     * Use getStaticType() instead, as single method to get types
     */
    protected function getObjectType(\PhpParser\Node $node) : \PHPStan\Type\Type
    {
        return $this->nodeTypeResolver->resolve($node);
    }
    /**
     * @param Node|Node[] $nodes
     */
    protected function traverseNodesWithCallable($nodes, callable $callable) : void
    {
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable($nodes, $callable);
    }
    /**
     * @param Node|Node[]|null $node
     */
    protected function print($node) : string
    {
        return $this->betterStandardPrinter->print($node);
    }
    protected function isAtLeastPhpVersion(int $version) : bool
    {
        return $this->phpVersionProvider->isAtLeastPhpVersion($version);
    }
    protected function mirrorComments(\PhpParser\Node $newNode, \PhpParser\Node $oldNode) : void
    {
        $newNode->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO, $oldNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO));
        $newNode->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, $oldNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS));
    }
    /**
     * @param Stmt[] $stmts
     */
    protected function unwrapStmts(array $stmts, \PhpParser\Node $node) : void
    {
        // move /* */ doc block from if to first element to keep it
        $currentPhpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);
        foreach ($stmts as $key => $ifStmt) {
            if ($key === 0) {
                $ifStmt->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO, $currentPhpDocInfo);
                // move // comments
                $ifStmt->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, $node->getComments());
            }
            $this->addNodeAfterNode($ifStmt, $node);
        }
    }
    protected function isOnClassMethodCall(\PhpParser\Node\Expr\MethodCall $methodCall, \PHPStan\Type\ObjectType $objectType, string $methodName) : bool
    {
        if (!$this->isObjectType($methodCall->var, $objectType)) {
            return \false;
        }
        return $this->isName($methodCall->name, $methodName);
    }
    protected function isOpenSourceProjectType() : bool
    {
        $projectType = $this->parameterProvider->provideStringParameter(\Rector\Core\Configuration\Option::PROJECT_TYPE);
        return $projectType === \Rector\Core\ValueObject\ProjectType::OPEN_SOURCE;
    }
    /**
     * @param Arg[] $newArgs
     * @param Arg[] $appendingArgs
     * @return Arg[]
     */
    protected function appendArgs(array $newArgs, array $appendingArgs) : array
    {
        foreach ($appendingArgs as $appendingArg) {
            $newArgs[] = new \PhpParser\Node\Arg($appendingArg->value);
        }
        return $newArgs;
    }
    protected function unwrapExpression(\PhpParser\Node\Stmt $stmt) : \PhpParser\Node
    {
        if ($stmt instanceof \PhpParser\Node\Stmt\Expression) {
            return $stmt->expr;
        }
        return $stmt;
    }
    /**
     * @param Node[] $newNodes
     */
    protected function addNodesAfterNode(array $newNodes, \PhpParser\Node $positionNode) : void
    {
        $this->nodesToAddCollector->addNodesAfterNode($newNodes, $positionNode);
    }
    /**
     * @param Node[] $newNodes
     */
    protected function addNodesBeforeNode(array $newNodes, \PhpParser\Node $positionNode) : void
    {
        $this->nodesToAddCollector->addNodesBeforeNode($newNodes, $positionNode);
    }
    protected function addNodeAfterNode(\PhpParser\Node $newNode, \PhpParser\Node $positionNode) : void
    {
        $this->nodesToAddCollector->addNodeAfterNode($newNode, $positionNode);
    }
    protected function addNodeBeforeNode(\PhpParser\Node $newNode, \PhpParser\Node $positionNode) : void
    {
        $this->nodesToAddCollector->addNodeBeforeNode($newNode, $positionNode);
    }
    protected function addConstructorDependencyToClass(\PhpParser\Node\Stmt\Class_ $class, \PHPStan\Type\Type $propertyType, string $propertyName, int $propertyFlags = 0) : void
    {
        $this->propertyAdder->addConstructorDependencyToClass($class, $propertyType, $propertyName, $propertyFlags);
    }
    protected function removeNode(\PhpParser\Node $node) : void
    {
        $this->nodeRemover->removeNode($node);
    }
    /**
     * @param Class_|ClassMethod|Function_ $nodeWithStatements
     */
    protected function removeNodeFromStatements(\PhpParser\Node $nodeWithStatements, \PhpParser\Node $nodeToRemove) : void
    {
        $this->nodeRemover->removeNodeFromStatements($nodeWithStatements, $nodeToRemove);
    }
    /**
     * @param Node[] $nodes
     */
    protected function removeNodes(array $nodes) : void
    {
        $this->nodeRemover->removeNodes($nodes);
    }
    private function isMatchingNodeType(string $nodeClass) : bool
    {
        foreach ($this->getNodeTypes() as $nodeType) {
            if (\is_a($nodeClass, $nodeType, \true)) {
                return \true;
            }
        }
        return \false;
    }
    private function shouldSkipCurrentNode(\PhpParser\Node $node) : bool
    {
        if ($this->nodesToRemoveCollector->isNodeRemoved($node)) {
            return \true;
        }
        if ($this->exclusionManager->isNodeSkippedByRector($node, $this)) {
            return \true;
        }
        $fileInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        if (!$fileInfo instanceof \RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo) {
            return \false;
        }
        return $this->skipper->shouldSkipElementAndFileInfo($this, $fileInfo);
    }
    private function printDebugApplying() : void
    {
        if (!$this->symfonyStyle->isDebug()) {
            return;
        }
        if ($this->previousAppliedClass === static::class) {
            return;
        }
        // prevent spamming with the same class over and over
        // indented on purpose to improve log nesting under [refactoring]
        $this->symfonyStyle->writeln('    [applying] ' . static::class);
        $this->previousAppliedClass = static::class;
    }
    private function hasNodeChanged(\PhpParser\Node $originalNode, \PhpParser\Node $node) : bool
    {
        if ($this->isNameIdentical($node, $originalNode)) {
            return \false;
        }
        return !$this->nodeComparator->areNodesEqual($originalNode, $node);
    }
    private function mirrorAttributes(\PhpParser\Node $oldNode, \PhpParser\Node $newNode) : void
    {
        foreach ($oldNode->getAttributes() as $attributeName => $oldNodeAttributeValue) {
            if (!\in_array($attributeName, self::ATTRIBUTES_TO_MIRROR, \true)) {
                continue;
            }
            $newNode->setAttribute($attributeName, $oldNodeAttributeValue);
        }
    }
    private function updateAttributes(\PhpParser\Node $node) : void
    {
        // update Resolved name attribute if name is changed
        if ($node instanceof \PhpParser\Node\Name) {
            $node->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::RESOLVED_NAME, $node->toString());
        }
    }
    private function keepFileInfoAttribute(\PhpParser\Node $node, \PhpParser\Node $originalNode) : void
    {
        $fileInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        if ($fileInfo instanceof \RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo) {
            return;
        }
        $fileInfo = $originalNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        $originalParent = $originalNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($fileInfo !== null) {
            $node->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO, $originalNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO));
        } elseif ($originalParent instanceof \PhpParser\Node) {
            $node->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO, $originalParent->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO));
        }
    }
    private function isNameIdentical(\PhpParser\Node $node, \PhpParser\Node $originalNode) : bool
    {
        if (!$originalNode instanceof \PhpParser\Node\Name) {
            return \false;
        }
        // names are the same
        return $this->nodeComparator->areNodesEqual($originalNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NAME), $node);
    }
}
