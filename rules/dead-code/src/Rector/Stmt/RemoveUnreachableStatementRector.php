<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DeadCode\Rector\Stmt;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Else_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Nop;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\While_;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/phpstan/phpstan/blob/83078fe308a383c618b8c1caec299e5765d9ac82/src/Node/UnreachableStatementNode.php
 *
 * @see \Rector\DeadCode\Tests\Rector\Stmt\RemoveUnreachableStatementRector\RemoveUnreachableStatementRectorTest
 */
final class RemoveUnreachableStatementRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove unreachable statements', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt::class];
    }
    /**
     * @param Stmt $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($this->shouldSkipNode($node)) {
            return null;
        }
        // might be PHPStan false positive, better skip
        $previousStatement = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_STATEMENT);
        if ($previousStatement instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_) {
            $node->setAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::IS_UNREACHABLE, $previousStatement->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::IS_UNREACHABLE));
        }
        if ($previousStatement instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\While_) {
            $node->setAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::IS_UNREACHABLE, $previousStatement->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::IS_UNREACHABLE));
        }
        if (!$this->isUnreachable($node)) {
            return null;
        }
        if ($this->isAfterMarkTestSkippedMethodCall($node)) {
            $node->setAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::IS_UNREACHABLE, \false);
            return null;
        }
        $this->removeNode($node);
        return null;
    }
    private function shouldSkipNode(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt $stmt) : bool
    {
        if ($stmt instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Nop) {
            return \true;
        }
        if ($stmt instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike) {
            return \true;
        }
        return $stmt instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike;
    }
    private function isUnreachable(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt $stmt) : bool
    {
        $isUnreachable = $stmt->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::IS_UNREACHABLE);
        if ($isUnreachable === \true) {
            return \true;
        }
        // traverse up for unreachable node in the same scope
        $previousNode = $stmt->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_STATEMENT);
        while ($previousNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt && !$this->isBreakingScopeNode($previousNode)) {
            $isUnreachable = $previousNode->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::IS_UNREACHABLE);
            if ($isUnreachable === \true) {
                return \true;
            }
            $previousNode = $previousNode->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_STATEMENT);
        }
        return \false;
    }
    /**
     * Keep content after markTestSkipped(), intentional temporary
     */
    private function isAfterMarkTestSkippedMethodCall(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt $stmt) : bool
    {
        return (bool) $this->betterNodeFinder->findFirstPrevious($stmt, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
                return \false;
            }
            if ($node->name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
                return \false;
            }
            if ($node->name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall) {
                return \false;
            }
            return $this->isName($node->name, 'markTestSkipped');
        });
    }
    /**
     * Check nodes that breaks scope while traversing up
     */
    private function isBreakingScopeNode(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt $stmt) : bool
    {
        if ($stmt instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike) {
            return \true;
        }
        if ($stmt instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod) {
            return \true;
        }
        if ($stmt instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_) {
            return \true;
        }
        return $stmt instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Else_;
    }
}
