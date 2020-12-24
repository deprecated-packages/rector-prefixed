<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DeadCode\Rector\FunctionLike;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Nop;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\FunctionLike\RemoveCodeAfterReturnRector\RemoveCodeAfterReturnRectorTest
 */
final class RemoveCodeAfterReturnRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove dead code after return statement', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_::class];
    }
    /**
     * @param Closure|ClassMethod|Function_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($node->stmts === null) {
            return null;
        }
        $isDeadAfterReturn = \false;
        foreach ($node->stmts as $key => $stmt) {
            if ($isDeadAfterReturn) {
                // keep comment
                if ($node->stmts[$key] instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Nop) {
                    continue;
                }
                $this->removeStmt($node, $key);
            }
            if ($stmt instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_) {
                $isDeadAfterReturn = \true;
                continue;
            }
        }
        return null;
    }
}
