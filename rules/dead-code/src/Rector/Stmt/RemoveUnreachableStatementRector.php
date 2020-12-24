<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DeadCode\Rector\Stmt;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Else_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\If_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Nop;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\While_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/phpstan/phpstan/blob/83078fe308a383c618b8c1caec299e5765d9ac82/src/Node/UnreachableStatementNode.php
 *
 * @see \Rector\DeadCode\Tests\Rector\Stmt\RemoveUnreachableStatementRector\RemoveUnreachableStatementRectorTest
 */
final class RemoveUnreachableStatementRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove unreachable statements', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        return 5;

        $removeMe = 10;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        return 5;
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt::class];
    }
    /**
     * @param Stmt $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($this->shouldSkipNode($node)) {
            return null;
        }
        // might be PHPStan false positive, better skip
        $previousStatement = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_STATEMENT);
        if ($previousStatement instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\If_) {
            $node->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::IS_UNREACHABLE, $previousStatement->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::IS_UNREACHABLE));
        }
        if ($previousStatement instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\While_) {
            $node->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::IS_UNREACHABLE, $previousStatement->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::IS_UNREACHABLE));
        }
        if (!$this->isUnreachable($node)) {
            return null;
        }
        if ($this->isAfterMarkTestSkippedMethodCall($node)) {
            $node->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::IS_UNREACHABLE, \false);
            return null;
        }
        $this->removeNode($node);
        return null;
    }
    private function shouldSkipNode(\_PhpScopere8e811afab72\PhpParser\Node\Stmt $stmt) : bool
    {
        if ($stmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Nop) {
            return \true;
        }
        if ($stmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike) {
            return \true;
        }
        return $stmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
    }
    private function isUnreachable(\_PhpScopere8e811afab72\PhpParser\Node\Stmt $stmt) : bool
    {
        $isUnreachable = $stmt->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::IS_UNREACHABLE);
        if ($isUnreachable === \true) {
            return \true;
        }
        // traverse up for unreachable node in the same scope
        $previousNode = $stmt->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_STATEMENT);
        while ($previousNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt && !$this->isBreakingScopeNode($previousNode)) {
            $isUnreachable = $previousNode->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::IS_UNREACHABLE);
            if ($isUnreachable === \true) {
                return \true;
            }
            $previousNode = $previousNode->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_STATEMENT);
        }
        return \false;
    }
    /**
     * Keep content after markTestSkipped(), intentional temporary
     */
    private function isAfterMarkTestSkippedMethodCall(\_PhpScopere8e811afab72\PhpParser\Node\Stmt $stmt) : bool
    {
        return (bool) $this->betterNodeFinder->findFirstPrevious($stmt, function (\_PhpScopere8e811afab72\PhpParser\Node $node) : bool {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
                return \false;
            }
            if ($node->name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
                return \false;
            }
            if ($node->name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall) {
                return \false;
            }
            return $this->isName($node->name, 'markTestSkipped');
        });
    }
    /**
     * Check nodes that breaks scope while traversing up
     */
    private function isBreakingScopeNode(\_PhpScopere8e811afab72\PhpParser\Node\Stmt $stmt) : bool
    {
        if ($stmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike) {
            return \true;
        }
        if ($stmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod) {
            return \true;
        }
        if ($stmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_) {
            return \true;
        }
        return $stmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Else_;
    }
}
