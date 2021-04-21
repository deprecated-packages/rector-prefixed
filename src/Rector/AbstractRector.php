<?php

declare(strict_types=1);

namespace Rector\Core\Rector;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
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
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\Exclusion\ExclusionManager;
use Rector\Core\Logging\CurrentRectorProvider;
use Rector\Core\NodeAnalyzer\ClassAnalyzer;
use Rector\Core\Php\PhpVersionProvider;
use Rector\Core\PhpParser\Comparing\NodeComparator;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\Core\PhpParser\Node\NodeFactory;
use Rector\Core\PhpParser\Node\Value\ValueResolver;
use Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use Rector\Core\Provider\CurrentFileProvider;
use Rector\Core\ValueObject\Application\File;
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
use Symfony\Component\Console\Style\SymfonyStyle;
use Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
use Symplify\PackageBuilder\Parameter\ParameterProvider;
use Symplify\Skipper\Skipper\Skipper;

/**
 * @see \Rector\Testing\PHPUnit\AbstractRectorTestCase
 */
abstract class AbstractRector extends NodeVisitorAbstract implements PhpRectorInterface
{
    /**
     * @var string[]
     */
    const ATTRIBUTES_TO_MIRROR = [
        AttributeKey::PARENT_NODE,
        AttributeKey::CLASS_NODE,
        AttributeKey::CLASS_NAME,
        AttributeKey::METHOD_NODE,
        AttributeKey::USE_NODES,
        AttributeKey::SCOPE,
        AttributeKey::RESOLVED_NAME,
    ];

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
     * @var File
     */
    protected $file;

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
     * @var CurrentFileProvider
     */
    private $currentFileProvider;

    /**
     * @required
     * @return void
     */
    public function autowireAbstractRector(
        NodesToRemoveCollector $nodesToRemoveCollector,
        NodesToAddCollector $nodesToAddCollector,
        RectorChangeCollector $rectorChangeCollector,
        NodeRemover $nodeRemover,
        PropertyAdder $propertyAdder,
        RemovedAndAddedFilesCollector $removedAndAddedFilesCollector,
        BetterStandardPrinter $betterStandardPrinter,
        NodeNameResolver $nodeNameResolver,
        NodeTypeResolver $nodeTypeResolver,
        SimpleCallableNodeTraverser $simpleCallableNodeTraverser,
        VisibilityManipulator $visibilityManipulator,
        NodeFactory $nodeFactory,
        PhpDocInfoFactory $phpDocInfoFactory,
        SymfonyStyle $symfonyStyle,
        PhpVersionProvider $phpVersionProvider,
        ExclusionManager $exclusionManager,
        StaticTypeMapper $staticTypeMapper,
        ParameterProvider $parameterProvider,
        CurrentRectorProvider $currentRectorProvider,
        ClassAnalyzer $classAnalyzer,
        CurrentNodeProvider $currentNodeProvider,
        Skipper $skipper,
        ValueResolver $valueResolver,
        NodeRepository $nodeRepository,
        BetterNodeFinder $betterNodeFinder,
        NodeComparator $nodeComparator,
        CurrentFileProvider $currentFileProvider
    ) {
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
        $this->currentFileProvider = $currentFileProvider;
    }

    /**
     * @return mixed[]|null
     */
    public function beforeTraverse(array $nodes)
    {
        $this->previousAppliedClass = null;

        // workaround for file around refactor()
        $file = $this->currentFileProvider->getFile();
        if (! $file instanceof File) {
            throw new ShouldNotHappenException('File is missing');
        }

        $this->file = $file;

        return parent::beforeTraverse($nodes);
    }

    /**
     * @return Expression|Node|null
     */
    final public function enterNode(Node $node)
    {
        $nodeClass = get_class($node);
        if (! $this->isMatchingNodeType($nodeClass)) {
            return null;
        }

        if ($this->shouldSkipCurrentNode($node)) {
            return null;
        }

        $this->currentRectorProvider->changeCurrentRector($this);
        // for PHP doc info factory and change notifier
        $this->currentNodeProvider->setNode($node);

        // show current Rector class on --debug
        $this->printDebugApplying();

        $originalAttributes = $node->getAttributes();
        $originalNode = $node->getAttribute(AttributeKey::ORIGINAL_NODE) ?? clone $node;

        $node = $this->refactor($node);

        // nothing to change → continue
        if (! $node instanceof Node) {
            return null;
        }

        // changed!
        if ($this->hasNodeChanged($originalNode, $node)) {
            $this->updateAttributes($node);

            $this->rectorChangeCollector->notifyFileChange($this->file, $node, $this);

            // update parents relations
            $this->connectParentNodes($node);

            $this->mirrorAttributes($originalAttributes, $node);
        }

        // if stmt ("$value;") was replaced by expr ("$value"), add the ending ";" (Expression) to prevent breaking the code
        if ($originalNode instanceof Stmt && $node instanceof Expr) {
            return new Expression($node);
        }

        return $node;
    }

    protected function isName(Node $node, string $name): bool
    {
        return $this->nodeNameResolver->isName($node, $name);
    }

    /**
     * @param string[] $names
     */
    protected function isNames(Node $node, array $names): bool
    {
        return $this->nodeNameResolver->isNames($node, $names);
    }

    /**
     * @return string|null
     */
    protected function getName(Node $node)
    {
        return $this->nodeNameResolver->getName($node);
    }

    protected function isObjectType(Node $node, ObjectType $objectType): bool
    {
        return $this->nodeTypeResolver->isObjectType($node, $objectType);
    }

    protected function getStaticType(Node $node): Type
    {
        return $this->nodeTypeResolver->getStaticType($node);
    }

    /**
     * @deprecated
     * Use getStaticType() instead, as single method to get types
     */
    protected function getObjectType(Node $node): Type
    {
        return $this->nodeTypeResolver->resolve($node);
    }

    /**
     * @param Node|Node[] $nodes
     * @return void
     */
    protected function traverseNodesWithCallable($nodes, callable $callable)
    {
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable($nodes, $callable);
    }

    /**
     * @param Node|Node[]|null $node
     */
    protected function print($node): string
    {
        return $this->betterStandardPrinter->print($node);
    }

    protected function isAtLeastPhpVersion(int $version): bool
    {
        return $this->phpVersionProvider->isAtLeastPhpVersion($version);
    }

    /**
     * @return void
     */
    protected function mirrorComments(Node $newNode, Node $oldNode)
    {
        $newNode->setAttribute(AttributeKey::PHP_DOC_INFO, $oldNode->getAttribute(AttributeKey::PHP_DOC_INFO));
        $newNode->setAttribute(AttributeKey::COMMENTS, $oldNode->getAttribute(AttributeKey::COMMENTS));
    }

    /**
     * @param Stmt[] $stmts
     * @return void
     */
    protected function unwrapStmts(array $stmts, Node $node)
    {
        // move /* */ doc block from if to first element to keep it
        $currentPhpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);

        foreach ($stmts as $key => $ifStmt) {
            if ($key === 0) {
                $ifStmt->setAttribute(AttributeKey::PHP_DOC_INFO, $currentPhpDocInfo);

                // move // comments
                $ifStmt->setAttribute(AttributeKey::COMMENTS, $node->getComments());
            }

            $this->addNodeAfterNode($ifStmt, $node);
        }
    }

    protected function isOpenSourceProjectType(): bool
    {
        $projectType = $this->parameterProvider->provideStringParameter(Option::PROJECT_TYPE);
        return $projectType === ProjectType::OPEN_SOURCE;
    }

    /**
     * @param Arg[] $newArgs
     * @param Arg[] $appendingArgs
     * @return Arg[]
     */
    protected function appendArgs(array $newArgs, array $appendingArgs): array
    {
        foreach ($appendingArgs as $appendingArg) {
            $newArgs[] = new Arg($appendingArg->value);
        }

        return $newArgs;
    }

    protected function unwrapExpression(Stmt $stmt): Node
    {
        if ($stmt instanceof Expression) {
            return $stmt->expr;
        }

        return $stmt;
    }

    /**
     * @param Node[] $newNodes
     * @return void
     */
    protected function addNodesAfterNode(array $newNodes, Node $positionNode)
    {
        $this->nodesToAddCollector->addNodesAfterNode($newNodes, $positionNode);
    }

    /**
     * @param Node[] $newNodes
     * @return void
     */
    protected function addNodesBeforeNode(array $newNodes, Node $positionNode)
    {
        $this->nodesToAddCollector->addNodesBeforeNode($newNodes, $positionNode);
    }

    /**
     * @return void
     */
    protected function addNodeAfterNode(Node $newNode, Node $positionNode)
    {
        $this->nodesToAddCollector->addNodeAfterNode($newNode, $positionNode);
    }

    /**
     * @return void
     */
    protected function addNodeBeforeNode(Node $newNode, Node $positionNode)
    {
        $this->nodesToAddCollector->addNodeBeforeNode($newNode, $positionNode);
    }

    /**
     * @return void
     */
    protected function addConstructorDependencyToClass(
        Class_ $class,
        Type $propertyType,
        string $propertyName,
        int $propertyFlags = 0
    ) {
        $this->propertyAdder->addConstructorDependencyToClass($class, $propertyType, $propertyName, $propertyFlags);
    }

    /**
     * @return void
     */
    protected function removeNode(Node $node)
    {
        $this->nodeRemover->removeNode($node);
    }

    /**
     * @param Class_|ClassMethod|Function_ $nodeWithStatements
     * @return void
     */
    protected function removeNodeFromStatements(Node $nodeWithStatements, Node $nodeToRemove)
    {
        $this->nodeRemover->removeNodeFromStatements($nodeWithStatements, $nodeToRemove);
    }

    /**
     * @param Node[] $nodes
     * @return void
     */
    protected function removeNodes(array $nodes)
    {
        $this->nodeRemover->removeNodes($nodes);
    }

    /**
     * @param class-string<Node> $nodeClass
     */
    private function isMatchingNodeType(string $nodeClass): bool
    {
        foreach ($this->getNodeTypes() as $nodeType) {
            if (is_a($nodeClass, $nodeType, true)) {
                return true;
            }
        }

        return false;
    }

    private function shouldSkipCurrentNode(Node $node): bool
    {
        if ($this->nodesToRemoveCollector->isNodeRemoved($node)) {
            return true;
        }

        if ($this->exclusionManager->isNodeSkippedByRector($node, $this)) {
            return true;
        }

        $smartFileInfo = $this->file->getSmartFileInfo();
        return $this->skipper->shouldSkipElementAndFileInfo($this, $smartFileInfo);
    }

    /**
     * @return void
     */
    private function printDebugApplying()
    {
        if (! $this->symfonyStyle->isDebug()) {
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

    private function hasNodeChanged(Node $originalNode, Node $node): bool
    {
        if ($this->isNameIdentical($node, $originalNode)) {
            return false;
        }

        return ! $this->nodeComparator->areNodesEqual($originalNode, $node);
    }

    /**
     * @param array<string, mixed> $originalAttributes
     * @return void
     */
    private function mirrorAttributes(array $originalAttributes, Node $newNode)
    {
        foreach ($originalAttributes as $attributeName => $oldAttributeValue) {
            if (! in_array($attributeName, self::ATTRIBUTES_TO_MIRROR, true)) {
                continue;
            }

            $newNode->setAttribute($attributeName, $oldAttributeValue);
        }
    }

    /**
     * @return void
     */
    private function updateAttributes(Node $node)
    {
        // update Resolved name attribute if name is changed
        if ($node instanceof Name) {
            $node->setAttribute(AttributeKey::RESOLVED_NAME, $node->toString());
        }
    }

    private function isNameIdentical(Node $node, Node $originalNode): bool
    {
        if (! $originalNode instanceof Name) {
            return false;
        }

        // names are the same
        return $this->nodeComparator->areNodesEqual($originalNode->getAttribute(AttributeKey::ORIGINAL_NAME), $node);
    }

    /**
     * @return void
     */
    private function connectParentNodes(Node $node)
    {
        $nodeTraverser = new NodeTraverser();
        $nodeTraverser->addVisitor(new ParentConnectingVisitor());
        $nodeTraverser->traverse([$node]);
    }
}
