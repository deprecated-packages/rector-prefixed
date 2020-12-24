<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php74\Rector\Closure;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrowFunction;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClosureUse;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/arrow_functions_v2
 *
 * @see \Rector\Php74\Tests\Rector\Closure\ClosureToArrowFunctionRector\ClosureToArrowFunctionRectorTest
 */
final class ClosureToArrowFunctionRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change closure to arrow function', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run($meetups)
    {
        return array_filter($meetups, function (Meetup $meetup) {
            return is_object($meetup);
        });
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run($meetups)
    {
        return array_filter($meetups, fn(Meetup $meetup) => is_object($meetup));
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure::class];
    }
    /**
     * @param Closure $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature::ARROW_FUNCTION)) {
            return null;
        }
        if (\count((array) $node->stmts) !== 1) {
            return null;
        }
        if (!$node->stmts[0] instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_) {
            return null;
        }
        /** @var Return_ $return */
        $return = $node->stmts[0];
        if ($return->expr === null) {
            return null;
        }
        if ($this->shouldSkipForUsedReferencedValue($node, $return)) {
            return null;
        }
        $arrowFunction = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrowFunction();
        $arrowFunction->params = $node->params;
        $arrowFunction->returnType = $node->returnType;
        $arrowFunction->byRef = $node->byRef;
        $arrowFunction->expr = $return->expr;
        if ($node->static) {
            $arrowFunction->static = \true;
        }
        return $arrowFunction;
    }
    private function shouldSkipForUsedReferencedValue(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure $closure, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_ $return) : bool
    {
        if ($return->expr === null) {
            return \false;
        }
        $referencedValues = $this->resolveReferencedUseVariablesFromClosure($closure);
        if ($referencedValues === []) {
            return \false;
        }
        return (bool) $this->betterNodeFinder->findFirst([$return->expr], function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($referencedValues) : bool {
            foreach ($referencedValues as $referencedValue) {
                if ($this->areNodesEqual($node, $referencedValue)) {
                    return \true;
                }
            }
            return \false;
        });
    }
    /**
     * @return Variable[]
     */
    private function resolveReferencedUseVariablesFromClosure(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure $closure) : array
    {
        $referencedValues = [];
        /** @var ClosureUse $use */
        foreach ((array) $closure->uses as $use) {
            if ($use->byRef) {
                $referencedValues[] = $use->var;
            }
        }
        return $referencedValues;
    }
}
