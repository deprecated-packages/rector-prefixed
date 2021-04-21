<?php

declare(strict_types=1);

namespace Rector\DeadCode\Rector\FunctionLike;

use PhpParser\Node;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\Nop;
use PhpParser\Node\Stmt\Return_;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Rector\Tests\DeadCode\Rector\FunctionLike\RemoveCodeAfterReturnRector\RemoveCodeAfterReturnRectorTest
 */
final class RemoveCodeAfterReturnRector extends AbstractRector
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Remove dead code after return statement', [
            new CodeSample(
                <<<'CODE_SAMPLE'
class SomeClass
{
    public function run(int $a)
    {
         return $a;
         $a++;
    }
}
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
class SomeClass
{
    public function run(int $a)
    {
         return $a;
    }
}
CODE_SAMPLE
            ),
        ]);
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [Closure::class, ClassMethod::class, Function_::class];
    }

    /**
     * @param Closure|ClassMethod|Function_ $node
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node)
    {
        if ($node->stmts === null) {
            return null;
        }

        $isDeadAfterReturn = false;
        foreach ($node->stmts as $key => $stmt) {
            if ($isDeadAfterReturn) {
                if (! isset($node->stmts[$key])) {
                    throw new ShouldNotHappenException();
                }

                // keep comment
                /** @var int $key */
                if ($node->stmts[$key] instanceof Nop) {
                    continue;
                }

                $this->nodeRemover->removeStmt($node, $key);
            }

            if ($stmt instanceof Return_) {
                $isDeadAfterReturn = true;
            }
        }

        return null;
    }
}
