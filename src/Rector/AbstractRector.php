<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\Rector;

use _PhpScoper0a6b37af0871\PhpParser\BuilderFactory;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Cast\Bool_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a6b37af0871\PhpParser\NodeVisitorAbstract;
use _PhpScoper0a6b37af0871\Rector\Core\Configuration\CurrentNodeProvider;
use _PhpScoper0a6b37af0871\Rector\Core\Configuration\Option;
use _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\PhpRectorInterface;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\Core\Exclusion\ExclusionManager;
use _PhpScoper0a6b37af0871\Rector\Core\Logging\CurrentRectorProvider;
use _PhpScoper0a6b37af0871\Rector\Core\NodeAnalyzer\ClassNodeAnalyzer;
use _PhpScoper0a6b37af0871\Rector\Core\Php\PhpVersionProvider;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector\AbstractRectorTrait;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\ProjectType;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockManipulator;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\StaticTypeMapper;
use _PhpScoper0a6b37af0871\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Parameter\ParameterProvider;
use _PhpScoper0a6b37af0871\Symplify\Skipper\Skipper\Skipper;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
abstract class AbstractRector extends \_PhpScoper0a6b37af0871\PhpParser\NodeVisitorAbstract implements \_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\PhpRectorInterface
{
    use AbstractRectorTrait;
    /**
     * @var string[]
     */
    private const ATTRIBUTES_TO_MIRROR = [\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::USE_NODES, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NAME, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NODE, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::RESOLVED_NAME];
    /**
     * @var string
     */
    private const COMMENTS = 'comments';
    /**
     * @var BuilderFactory
     */
    protected $builderFactory;
    /**
     * @var ParameterProvider
     */
    protected $parameterProvider;
    /**
     * @var PhpVersionProvider
     */
    protected $phpVersionProvider;
    /**
     * @var DocBlockManipulator
     */
    protected $docBlockManipulator;
    /**
     * @var StaticTypeMapper
     */
    protected $staticTypeMapper;
    /**
     * @var SmartFileInfo
     */
    private $currentFileInfo;
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
     * @var ClassNodeAnalyzer
     */
    private $classNodeAnalyzer;
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
     * @required
     */
    public function autowireAbstractRector(\_PhpScoper0a6b37af0871\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \_PhpScoper0a6b37af0871\Rector\Core\Php\PhpVersionProvider $phpVersionProvider, \_PhpScoper0a6b37af0871\PhpParser\BuilderFactory $builderFactory, \_PhpScoper0a6b37af0871\Rector\Core\Exclusion\ExclusionManager $exclusionManager, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockManipulator $docBlockManipulator, \_PhpScoper0a6b37af0871\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \_PhpScoper0a6b37af0871\Rector\Core\Logging\CurrentRectorProvider $currentRectorProvider, \_PhpScoper0a6b37af0871\Rector\Core\NodeAnalyzer\ClassNodeAnalyzer $classNodeAnalyzer, \_PhpScoper0a6b37af0871\Rector\Core\Configuration\CurrentNodeProvider $currentNodeProvider, \_PhpScoper0a6b37af0871\Symplify\Skipper\Skipper\Skipper $skipper) : void
    {
        $this->symfonyStyle = $symfonyStyle;
        $this->phpVersionProvider = $phpVersionProvider;
        $this->builderFactory = $builderFactory;
        $this->exclusionManager = $exclusionManager;
        $this->docBlockManipulator = $docBlockManipulator;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->parameterProvider = $parameterProvider;
        $this->currentRectorProvider = $currentRectorProvider;
        $this->classNodeAnalyzer = $classNodeAnalyzer;
        $this->currentNodeProvider = $currentNodeProvider;
        $this->skipper = $skipper;
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
     * @param string[] $types
     */
    public function hasParentTypes(\_PhpScoper0a6b37af0871\PhpParser\Node $node, array $types) : bool
    {
        foreach ($types as $type) {
            if (!\is_a($type, \_PhpScoper0a6b37af0871\PhpParser\Node::class, \true)) {
                throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException(__METHOD__);
            }
            if ($this->hasParentType($node, $type)) {
                return \true;
            }
        }
        return \false;
    }
    public function hasParentType(\_PhpScoper0a6b37af0871\PhpParser\Node $node, string $type) : bool
    {
        $parent = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent === null) {
            return \false;
        }
        return \is_a($parent, $type, \true);
    }
    /**
     * @return Expression|Node|null
     */
    public final function enterNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node)
    {
        $nodeClass = \get_class($node);
        if (!$this->isMatchingNodeType($nodeClass)) {
            return null;
        }
        $this->currentFileInfo = $node->getAttribute(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo::class);
        $this->currentRectorProvider->changeCurrentRector($this);
        // mostly for PHP doc and change notifications
        $this->currentNodeProvider->setNode($node);
        // already removed
        if ($this->isNodeRemoved($node)) {
            return null;
        }
        if ($this->exclusionManager->isNodeSkippedByRector($this, $node)) {
            return null;
        }
        $fileInfo = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        if ($fileInfo instanceof \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo && $this->skipper->shouldSkipElementAndFileInfo($this, $fileInfo)) {
            return null;
        }
        // show current Rector class on --debug
        $this->printDebugApplying();
        $originalNode = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE) ?? clone $node;
        $originalNodeWithAttributes = clone $node;
        $node = $this->refactor($node);
        // nothing to change → continue
        if ($node === null) {
            return null;
        }
        // changed!
        if ($this->hasNodeChanged($originalNode, $node)) {
            $this->mirrorAttributes($originalNodeWithAttributes, $node);
            $this->updateAttributes($node);
            $this->keepFileInfoAttribute($node, $originalNode);
            $this->notifyNodeFileInfo($node);
        }
        // if stmt ("$value;") was replaced by expr ("$value"), add the ending ";" (Expression) to prevent breaking the code
        if ($originalNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt && $node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr) {
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression($node);
        }
        return $node;
    }
    protected function getNextExpression(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $currentExpression = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        if (!$currentExpression instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression) {
            return null;
        }
        return $currentExpression->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
    }
    /**
     * @param Expr[]|null[] $nodes
     * @param mixed[] $expectedValues
     */
    protected function areValues(array $nodes, array $expectedValues) : bool
    {
        foreach ($nodes as $i => $node) {
            if ($node !== null && $this->isValue($node, $expectedValues[$i])) {
                continue;
            }
            return \false;
        }
        return \true;
    }
    protected function isAtLeastPhpVersion(int $version) : bool
    {
        return $this->phpVersionProvider->isAtLeastPhpVersion($version);
    }
    protected function isAnonymousClass(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
    {
        return $this->classNodeAnalyzer->isAnonymousClass($node);
    }
    protected function mirrorComments(\_PhpScoper0a6b37af0871\PhpParser\Node $newNode, \_PhpScoper0a6b37af0871\PhpParser\Node $oldNode) : void
    {
        $newNode->setAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO, $oldNode->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO));
        $newNode->setAttribute(self::COMMENTS, $oldNode->getAttribute(self::COMMENTS));
    }
    /**
     * @param Stmt[] $stmts
     */
    protected function unwrapStmts(array $stmts, \_PhpScoper0a6b37af0871\PhpParser\Node $node) : void
    {
        foreach ($stmts as $key => $ifStmt) {
            if ($key === 0) {
                // move /* */ doc block from if to first element to keep it
                $currentPhpDocInfo = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
                $ifStmt->setAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO, $currentPhpDocInfo);
                // move // comments
                $ifStmt->setAttribute(self::COMMENTS, $node->getComments());
            }
            $this->addNodeAfterNode($ifStmt, $node);
        }
    }
    protected function isOnClassMethodCall(\_PhpScoper0a6b37af0871\PhpParser\Node $node, string $type, string $methodName) : bool
    {
        if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        if (!$this->isObjectType($node->var, $type)) {
            return \false;
        }
        return $this->isName($node->name, $methodName);
    }
    protected function isOpenSourceProjectType() : bool
    {
        $projectType = $this->parameterProvider->provideParameter(\_PhpScoper0a6b37af0871\Rector\Core\Configuration\Option::PROJECT_TYPE);
        return \in_array(
            $projectType,
            // make it typo proof
            [\_PhpScoper0a6b37af0871\Rector\Core\ValueObject\ProjectType::OPEN_SOURCE, \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\ProjectType::OPEN_SOURCE_UNDESCORED],
            \true
        );
    }
    /**
     * @param Expr $expr
     */
    protected function createBoolCast(?\_PhpScoper0a6b37af0871\PhpParser\Node $parentNode, \_PhpScoper0a6b37af0871\PhpParser\Node $expr) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Cast\Bool_
    {
        if ($parentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_ && $expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign) {
            $expr = $expr->expr;
        }
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Cast\Bool_($expr);
    }
    /**
     * @param Arg[] $newArgs
     * @param Arg[] $appendingArgs
     * @return Arg[]
     */
    protected function appendArgs(array $newArgs, array $appendingArgs) : array
    {
        foreach ($appendingArgs as $oldArgument) {
            $newArgs[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($oldArgument->value);
        }
        return $newArgs;
    }
    protected function getFileInfo() : \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo
    {
        if ($this->currentFileInfo === null) {
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
        }
        return $this->currentFileInfo;
    }
    protected function unwrapExpression(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt $stmt) : \_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($stmt instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression) {
            return $stmt->expr;
        }
        return $stmt;
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
    private function hasNodeChanged(\_PhpScoper0a6b37af0871\PhpParser\Node $originalNode, \_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
    {
        if ($this->isNameIdentical($node, $originalNode)) {
            return \false;
        }
        return !$this->areNodesEqual($originalNode, $node);
    }
    private function mirrorAttributes(\_PhpScoper0a6b37af0871\PhpParser\Node $oldNode, \_PhpScoper0a6b37af0871\PhpParser\Node $newNode) : void
    {
        foreach ($oldNode->getAttributes() as $attributeName => $oldNodeAttributeValue) {
            if (!\in_array($attributeName, self::ATTRIBUTES_TO_MIRROR, \true)) {
                continue;
            }
            $newNode->setAttribute($attributeName, $oldNodeAttributeValue);
        }
    }
    private function updateAttributes(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : void
    {
        // update Resolved name attribute if name is changed
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name) {
            $node->setAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::RESOLVED_NAME, $node->toString());
        }
    }
    private function keepFileInfoAttribute(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PhpParser\Node $originalNode) : void
    {
        $fileInfo = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        if ($fileInfo instanceof \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo) {
            return;
        }
        $fileInfo = $originalNode->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        $originalParent = $originalNode->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($fileInfo !== null) {
            $node->setAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO, $originalNode->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO));
        } elseif ($originalParent instanceof \_PhpScoper0a6b37af0871\PhpParser\Node) {
            $node->setAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO, $originalParent->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO));
        }
    }
    private function isNameIdentical(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PhpParser\Node $originalNode) : bool
    {
        if (!$originalNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name) {
            return \false;
        }
        // names are the same
        return $this->areNodesEqual($originalNode->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NAME), $node);
    }
}
