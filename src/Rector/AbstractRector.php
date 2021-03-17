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
use RectorPrefix20210317\Symfony\Component\Console\Style\SymfonyStyle;
use RectorPrefix20210317\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
use RectorPrefix20210317\Symplify\PackageBuilder\Parameter\ParameterProvider;
use RectorPrefix20210317\Symplify\Skipper\Skipper\Skipper;
use RectorPrefix20210317\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Rector\Testing\PHPUnit\AbstractRectorTestCase
 */
abstract class AbstractRector extends \PhpParser\NodeVisitorAbstract implements \Rector\Core\Contract\Rector\PhpRectorInterface
{
    /**
     * @var string[]
     */
    private const ATTRIBUTES_TO_MIRROR = [\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, \Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE, \Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME, \Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO, \Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE, \Rector\NodeTypeResolver\Node\AttributeKey::USE_NODES, \Rector\NodeTypeResolver\Node\AttributeKey::SCOPE, \Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME, \Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NAME, \Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NODE, \Rector\NodeTypeResolver\Node\AttributeKey::RESOLVED_NAME];
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
     * @param \Rector\PostRector\Collector\NodesToRemoveCollector $nodesToRemoveCollector
     * @param \Rector\PostRector\Collector\NodesToAddCollector $nodesToAddCollector
     * @param \Rector\ChangesReporting\Collector\RectorChangeCollector $rectorChangeCollector
     * @param \Rector\NodeRemoval\NodeRemover $nodeRemover
     * @param \Rector\PostRector\DependencyInjection\PropertyAdder $propertyAdder
     * @param \Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector $removedAndAddedFilesCollector
     * @param \Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter
     * @param \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver
     * @param \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver
     * @param \Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser $simpleCallableNodeTraverser
     * @param \Rector\Privatization\NodeManipulator\VisibilityManipulator $visibilityManipulator
     * @param \Rector\Core\PhpParser\Node\NodeFactory $nodeFactory
     * @param \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory
     * @param \Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle
     * @param \Rector\Core\Php\PhpVersionProvider $phpVersionProvider
     * @param \Rector\Core\Exclusion\ExclusionManager $exclusionManager
     * @param \Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper
     * @param \Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider
     * @param \Rector\Core\Logging\CurrentRectorProvider $currentRectorProvider
     * @param \Rector\Core\NodeAnalyzer\ClassAnalyzer $classAnalyzer
     * @param \Rector\Core\Configuration\CurrentNodeProvider $currentNodeProvider
     * @param \Symplify\Skipper\Skipper\Skipper $skipper
     * @param \Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver
     * @param \Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository
     * @param \Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder
     * @param \Rector\Core\PhpParser\Comparing\NodeComparator $nodeComparator
     */
    public function autowireAbstractRector($nodesToRemoveCollector, $nodesToAddCollector, $rectorChangeCollector, $nodeRemover, $propertyAdder, $removedAndAddedFilesCollector, $betterStandardPrinter, $nodeNameResolver, $nodeTypeResolver, $simpleCallableNodeTraverser, $visibilityManipulator, $nodeFactory, $phpDocInfoFactory, $symfonyStyle, $phpVersionProvider, $exclusionManager, $staticTypeMapper, $parameterProvider, $currentRectorProvider, $classAnalyzer, $currentNodeProvider, $skipper, $valueResolver, $nodeRepository, $betterNodeFinder, $nodeComparator) : void
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
     * @param mixed[] $nodes
     */
    public function beforeTraverse($nodes) : ?array
    {
        $this->previousAppliedClass = null;
        return parent::beforeTraverse($nodes);
    }
    /**
     * @return Expression|Node|null
     * @param \PhpParser\Node $node
     */
    public final function enterNode($node)
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
            $this->mirrorAttributes($originalNodeWithAttributes, $node);
            $this->updateAttributes($node);
            $this->keepFileInfoAttribute($node, $originalNode);
            $this->rectorChangeCollector->notifyNodeFileInfo($node);
        }
        // if stmt ("$value;") was replaced by expr ("$value"), add the ending ";" (Expression) to prevent breaking the code
        if ($originalNode instanceof \PhpParser\Node\Stmt && $node instanceof \PhpParser\Node\Expr) {
            return new \PhpParser\Node\Stmt\Expression($node);
        }
        return $node;
    }
    /**
     * @param \PhpParser\Node $node
     * @param string $name
     */
    protected function isName($node, $name) : bool
    {
        return $this->nodeNameResolver->isName($node, $name);
    }
    /**
     * @param string[] $names
     * @param \PhpParser\Node $node
     */
    protected function isNames($node, $names) : bool
    {
        return $this->nodeNameResolver->isNames($node, $names);
    }
    /**
     * @param \PhpParser\Node $node
     */
    protected function getName($node) : ?string
    {
        return $this->nodeNameResolver->getName($node);
    }
    /**
     * @param \PhpParser\Node $node
     * @param \PHPStan\Type\ObjectType $objectType
     */
    protected function isObjectType($node, $objectType) : bool
    {
        return $this->nodeTypeResolver->isObjectType($node, $objectType);
    }
    /**
     * @param \PhpParser\Node $node
     */
    protected function getStaticType($node) : \PHPStan\Type\Type
    {
        return $this->nodeTypeResolver->getStaticType($node);
    }
    /**
     * @deprecated
     * Use getStaticType() instead, as single method to get types
     * @param \PhpParser\Node $node
     */
    protected function getObjectType($node) : \PHPStan\Type\Type
    {
        return $this->nodeTypeResolver->resolve($node);
    }
    /**
     * @param Node|Node[] $nodes
     * @param callable $callable
     */
    protected function traverseNodesWithCallable($nodes, $callable) : void
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
    /**
     * @param int $version
     */
    protected function isAtLeastPhpVersion($version) : bool
    {
        return $this->phpVersionProvider->isAtLeastPhpVersion($version);
    }
    /**
     * @param \PhpParser\Node $newNode
     * @param \PhpParser\Node $oldNode
     */
    protected function mirrorComments($newNode, $oldNode) : void
    {
        $newNode->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO, $oldNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO));
        $newNode->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, $oldNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS));
    }
    /**
     * @param Stmt[] $stmts
     * @param \PhpParser\Node $node
     */
    protected function unwrapStmts($stmts, $node) : void
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
    /**
     * @param \PhpParser\Node\Expr\MethodCall $methodCall
     * @param \PHPStan\Type\ObjectType $objectType
     * @param string $methodName
     */
    protected function isOnClassMethodCall($methodCall, $objectType, $methodName) : bool
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
    protected function appendArgs($newArgs, $appendingArgs) : array
    {
        foreach ($appendingArgs as $appendingArg) {
            $newArgs[] = new \PhpParser\Node\Arg($appendingArg->value);
        }
        return $newArgs;
    }
    /**
     * @param \PhpParser\Node\Stmt $stmt
     */
    protected function unwrapExpression($stmt) : \PhpParser\Node
    {
        if ($stmt instanceof \PhpParser\Node\Stmt\Expression) {
            return $stmt->expr;
        }
        return $stmt;
    }
    /**
     * @param Node[] $newNodes
     * @param \PhpParser\Node $positionNode
     */
    protected function addNodesAfterNode($newNodes, $positionNode) : void
    {
        $this->nodesToAddCollector->addNodesAfterNode($newNodes, $positionNode);
    }
    /**
     * @param Node[] $newNodes
     * @param \PhpParser\Node $positionNode
     */
    protected function addNodesBeforeNode($newNodes, $positionNode) : void
    {
        $this->nodesToAddCollector->addNodesBeforeNode($newNodes, $positionNode);
    }
    /**
     * @param \PhpParser\Node $newNode
     * @param \PhpParser\Node $positionNode
     */
    protected function addNodeAfterNode($newNode, $positionNode) : void
    {
        $this->nodesToAddCollector->addNodeAfterNode($newNode, $positionNode);
    }
    /**
     * @param \PhpParser\Node $newNode
     * @param \PhpParser\Node $positionNode
     */
    protected function addNodeBeforeNode($newNode, $positionNode) : void
    {
        $this->nodesToAddCollector->addNodeBeforeNode($newNode, $positionNode);
    }
    /**
     * @param \PhpParser\Node\Stmt\Class_ $class
     * @param \PHPStan\Type\Type $propertyType
     * @param string $propertyName
     * @param int $propertyFlags
     */
    protected function addConstructorDependencyToClass($class, $propertyType, $propertyName, $propertyFlags = 0) : void
    {
        $this->propertyAdder->addConstructorDependencyToClass($class, $propertyType, $propertyName, $propertyFlags);
    }
    /**
     * @param \PhpParser\Node $node
     */
    protected function removeNode($node) : void
    {
        $this->nodeRemover->removeNode($node);
    }
    /**
     * @param Class_|ClassMethod|Function_ $nodeWithStatements
     * @param \PhpParser\Node $nodeToRemove
     */
    protected function removeNodeFromStatements($nodeWithStatements, $nodeToRemove) : void
    {
        $this->nodeRemover->removeNodeFromStatements($nodeWithStatements, $nodeToRemove);
    }
    /**
     * @param Node[] $nodes
     */
    protected function removeNodes($nodes) : void
    {
        $this->nodeRemover->removeNodes($nodes);
    }
    /**
     * @param string $nodeClass
     */
    private function isMatchingNodeType($nodeClass) : bool
    {
        foreach ($this->getNodeTypes() as $nodeType) {
            if (\is_a($nodeClass, $nodeType, \true)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @param \PhpParser\Node $node
     */
    private function shouldSkipCurrentNode($node) : bool
    {
        if ($this->nodesToRemoveCollector->isNodeRemoved($node)) {
            return \true;
        }
        if ($this->exclusionManager->isNodeSkippedByRector($node, $this)) {
            return \true;
        }
        $fileInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        if (!$fileInfo instanceof \RectorPrefix20210317\Symplify\SmartFileSystem\SmartFileInfo) {
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
    /**
     * @param \PhpParser\Node $originalNode
     * @param \PhpParser\Node $node
     */
    private function hasNodeChanged($originalNode, $node) : bool
    {
        if ($this->isNameIdentical($node, $originalNode)) {
            return \false;
        }
        return !$this->nodeComparator->areNodesEqual($originalNode, $node);
    }
    /**
     * @param \PhpParser\Node $oldNode
     * @param \PhpParser\Node $newNode
     */
    private function mirrorAttributes($oldNode, $newNode) : void
    {
        foreach ($oldNode->getAttributes() as $attributeName => $oldNodeAttributeValue) {
            if (!\in_array($attributeName, self::ATTRIBUTES_TO_MIRROR, \true)) {
                continue;
            }
            $newNode->setAttribute($attributeName, $oldNodeAttributeValue);
        }
    }
    /**
     * @param \PhpParser\Node $node
     */
    private function updateAttributes($node) : void
    {
        // update Resolved name attribute if name is changed
        if ($node instanceof \PhpParser\Node\Name) {
            $node->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::RESOLVED_NAME, $node->toString());
        }
    }
    /**
     * @param \PhpParser\Node $node
     * @param \PhpParser\Node $originalNode
     */
    private function keepFileInfoAttribute($node, $originalNode) : void
    {
        $fileInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        if ($fileInfo instanceof \RectorPrefix20210317\Symplify\SmartFileSystem\SmartFileInfo) {
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
    /**
     * @param \PhpParser\Node $node
     * @param \PhpParser\Node $originalNode
     */
    private function isNameIdentical($node, $originalNode) : bool
    {
        if (!$originalNode instanceof \PhpParser\Node\Name) {
            return \false;
        }
        // names are the same
        return $this->nodeComparator->areNodesEqual($originalNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NAME), $node);
    }
}
