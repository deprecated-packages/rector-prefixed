<?php

declare (strict_types=1);
namespace Rector\Core\Rector;

use PhpParser\BuilderFactory;
use PhpParser\Comment;
use PhpParser\Comment\Doc;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Cast\Bool_;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Return_;
use PhpParser\NodeVisitorAbstract;
use Rector\Core\Configuration\CurrentNodeProvider;
use Rector\Core\Configuration\Option;
use Rector\Core\Contract\Rector\PhpRectorInterface;
use Rector\Core\Exclusion\ExclusionManager;
use Rector\Core\Logging\CurrentRectorProvider;
use Rector\Core\NodeAnalyzer\ClassNodeAnalyzer;
use Rector\Core\Php\PhpVersionProvider;
use Rector\Core\Rector\AbstractRector\AbstractRectorTrait;
use Rector\Core\ValueObject\ProjectType;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\StaticTypeMapper\StaticTypeMapper;
use RectorPrefix20210125\Symfony\Component\Console\Style\SymfonyStyle;
use RectorPrefix20210125\Symplify\PackageBuilder\Parameter\ParameterProvider;
use RectorPrefix20210125\Symplify\Skipper\Skipper\Skipper;
use RectorPrefix20210125\Symplify\SmartFileSystem\SmartFileInfo;
abstract class AbstractRector extends \PhpParser\NodeVisitorAbstract implements \Rector\Core\Contract\Rector\PhpRectorInterface
{
    use AbstractRectorTrait;
    /**
     * @var string[]
     */
    private const ATTRIBUTES_TO_MIRROR = [\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, \Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE, \Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME, \Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO, \Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE, \Rector\NodeTypeResolver\Node\AttributeKey::USE_NODES, \Rector\NodeTypeResolver\Node\AttributeKey::SCOPE, \Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME, \Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NAME, \Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NODE, \Rector\NodeTypeResolver\Node\AttributeKey::RESOLVED_NAME];
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
     * @var StaticTypeMapper
     */
    protected $staticTypeMapper;
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
    public function autowireAbstractRector(\RectorPrefix20210125\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \Rector\Core\Php\PhpVersionProvider $phpVersionProvider, \PhpParser\BuilderFactory $builderFactory, \Rector\Core\Exclusion\ExclusionManager $exclusionManager, \Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \RectorPrefix20210125\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \Rector\Core\Logging\CurrentRectorProvider $currentRectorProvider, \Rector\Core\NodeAnalyzer\ClassNodeAnalyzer $classNodeAnalyzer, \Rector\Core\Configuration\CurrentNodeProvider $currentNodeProvider, \RectorPrefix20210125\Symplify\Skipper\Skipper\Skipper $skipper) : void
    {
        $this->symfonyStyle = $symfonyStyle;
        $this->phpVersionProvider = $phpVersionProvider;
        $this->builderFactory = $builderFactory;
        $this->exclusionManager = $exclusionManager;
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
            $this->mirrorAttributes($originalNodeWithAttributes, $node);
            $this->updateAttributes($node);
            $this->keepFileInfoAttribute($node, $originalNode);
            $this->notifyNodeFileInfo($node);
        }
        // if stmt ("$value;") was replaced by expr ("$value"), add the ending ";" (Expression) to prevent breaking the code
        if ($originalNode instanceof \PhpParser\Node\Stmt && $node instanceof \PhpParser\Node\Expr) {
            return new \PhpParser\Node\Stmt\Expression($node);
        }
        return $node;
    }
    protected function getNextExpression(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $currentExpression = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        if (!$currentExpression instanceof \PhpParser\Node\Stmt\Expression) {
            return null;
        }
        return $currentExpression->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
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
    protected function isAnonymousClass(\PhpParser\Node $node) : bool
    {
        return $this->classNodeAnalyzer->isAnonymousClass($node);
    }
    protected function mirrorComments(\PhpParser\Node $newNode, \PhpParser\Node $oldNode) : void
    {
        $newNode->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO, $oldNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO));
        $newNode->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, $oldNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS));
    }
    protected function rollbackComments(\PhpParser\Node $node, \PhpParser\Comment $comment) : void
    {
        $node->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, null);
        $node->setDocComment(new \PhpParser\Comment\Doc($comment->getText()));
        $node->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO, null);
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
    protected function isOnClassMethodCall(\PhpParser\Node $node, string $type, string $methodName) : bool
    {
        if (!$node instanceof \PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        if (!$this->isObjectType($node->var, $type)) {
            return \false;
        }
        return $this->isName($node->name, $methodName);
    }
    protected function isOpenSourceProjectType() : bool
    {
        $projectType = $this->parameterProvider->provideParameter(\Rector\Core\Configuration\Option::PROJECT_TYPE);
        return \in_array(
            $projectType,
            // make it typo proof
            [\Rector\Core\ValueObject\ProjectType::OPEN_SOURCE, \Rector\Core\ValueObject\ProjectType::OPEN_SOURCE_UNDESCORED],
            \true
        );
    }
    /**
     * @param Expr $expr
     */
    protected function createBoolCast(?\PhpParser\Node $parentNode, \PhpParser\Node $expr) : \PhpParser\Node\Expr\Cast\Bool_
    {
        if ($parentNode instanceof \PhpParser\Node\Stmt\Return_ && $expr instanceof \PhpParser\Node\Expr\Assign) {
            $expr = $expr->expr;
        }
        return new \PhpParser\Node\Expr\Cast\Bool_($expr);
    }
    /**
     * @param Arg[] $newArgs
     * @param Arg[] $appendingArgs
     * @return Arg[]
     */
    protected function appendArgs(array $newArgs, array $appendingArgs) : array
    {
        foreach ($appendingArgs as $oldArgument) {
            $newArgs[] = new \PhpParser\Node\Arg($oldArgument->value);
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
        if ($this->isNodeRemoved($node)) {
            return \true;
        }
        if ($this->exclusionManager->isNodeSkippedByRector($node, $this)) {
            return \true;
        }
        $fileInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        if (!$fileInfo instanceof \RectorPrefix20210125\Symplify\SmartFileSystem\SmartFileInfo) {
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
        return !$this->areNodesEqual($originalNode, $node);
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
        if ($fileInfo instanceof \RectorPrefix20210125\Symplify\SmartFileSystem\SmartFileInfo) {
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
        return $this->areNodesEqual($originalNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NAME), $node);
    }
}
