<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\DeadCode\Rector\FunctionLike;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Closure;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Function_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Nop;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\FunctionLike\RemoveCodeAfterReturnRector\RemoveCodeAfterReturnRectorTest
 */
final class RemoveCodeAfterReturnRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove dead code after return statement', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run(int $a)
    {
         return $a;
         $a++;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run(int $a)
    {
         return $a;
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Closure::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Function_::class];
    }
    /**
     * @param Closure|ClassMethod|Function_ $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if ($node->stmts === null) {
            return null;
        }
        $isDeadAfterReturn = \false;
        foreach ($node->stmts as $key => $stmt) {
            if ($isDeadAfterReturn) {
                // keep comment
                if ($node->stmts[$key] instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Nop) {
                    continue;
                }
                $this->removeStmt($node, $key);
            }
            if ($stmt instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_) {
                $isDeadAfterReturn = \true;
                continue;
            }
        }
        return null;
    }
}
