<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DeadCode\Rector\ClassMethod;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\DeadCode\Comparator\CurrentAndParentClassMethodComparator;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\PhpAttribute\ValueObject\TagName;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\ClassMethod\RemoveDelegatingParentCallRector\RemoveDelegatingParentCallRectorTest
 */
final class RemoveDelegatingParentCallRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var CurrentAndParentClassMethodComparator
     */
    private $currentAndParentClassMethodComparator;
    public function __construct(\_PhpScopere8e811afab72\Rector\DeadCode\Comparator\CurrentAndParentClassMethodComparator $currentAndParentClassMethodComparator)
    {
        $this->currentAndParentClassMethodComparator = $currentAndParentClassMethodComparator;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Removed dead parent call, that does not change anything', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function prettyPrint(array $stmts): string
    {
        return parent::prettyPrint($stmts);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $classLike = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($this->shouldSkipClass($classLike)) {
            return null;
        }
        if ($node->stmts === null || \count((array) $node->stmts) !== 1) {
            return null;
        }
        $stmtsValues = \array_values($node->stmts);
        $onlyStmt = $this->unwrapExpression($stmtsValues[0]);
        // are both return?
        if ($this->isMethodReturnType($node, 'void') && !$onlyStmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_) {
            return null;
        }
        $staticCall = $this->matchStaticCall($onlyStmt);
        if ($staticCall === null) {
            return null;
        }
        if (!$this->currentAndParentClassMethodComparator->isParentCallMatching($node, $staticCall)) {
            return null;
        }
        if ($this->hasRequiredAnnotation($node)) {
            return null;
        }
        // the method is just delegation, nothing extra
        $this->removeNode($node);
        return null;
    }
    private function shouldSkipClass(?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike $classLike) : bool
    {
        if (!$classLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
            return \true;
        }
        return $classLike->extends === null;
    }
    private function isMethodReturnType(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, string $type) : bool
    {
        if ($classMethod->returnType === null) {
            return \false;
        }
        return $this->isName($classMethod->returnType, $type);
    }
    private function matchStaticCall(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall
    {
        // must be static call
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_) {
            if ($node->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall) {
                return $node->expr;
            }
            return null;
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall) {
            return $node;
        }
        return null;
    }
    private function hasRequiredAnnotation(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $classMethod->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return \false;
        }
        return $phpDocInfo->hasByName(\_PhpScopere8e811afab72\Rector\PhpAttribute\ValueObject\TagName::REQUIRED);
    }
}
