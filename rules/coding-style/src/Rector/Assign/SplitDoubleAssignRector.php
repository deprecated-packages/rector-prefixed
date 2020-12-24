<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodingStyle\Rector\Assign;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\Assign\SplitDoubleAssignRector\SplitDoubleAssignRectorTest
 */
final class SplitDoubleAssignRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Split multiple inline assigns to each own lines default value, to prevent undefined array issues', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $one = $two = 1;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $one = 1;
        $two = 1;
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign::class];
    }
    /**
     * @param Assign $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $parent = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parent instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression) {
            return null;
        }
        if (!$node->expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign) {
            return null;
        }
        $newAssign = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign($node->var, $node->expr->expr);
        if (!$this->isExprCallOrNew($node->expr->expr)) {
            $this->addNodeAfterNode($node->expr, $node);
            return $newAssign;
        }
        $varAssign = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign($node->expr->var, $node->var);
        $this->addNodeBeforeNode(new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression($newAssign), $node);
        return $varAssign;
    }
    private function isExprCallOrNew(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : bool
    {
        if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
            return \true;
        }
        if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall) {
            return \true;
        }
        if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall) {
            return \true;
        }
        return $expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_;
    }
}
