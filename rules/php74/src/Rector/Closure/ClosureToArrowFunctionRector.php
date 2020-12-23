<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Php74\Rector\Closure;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrowFunction;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Closure;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClosureUse;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/arrow_functions_v2
 *
 * @see \Rector\Php74\Tests\Rector\Closure\ClosureToArrowFunctionRector\ClosureToArrowFunctionRectorTest
 */
final class ClosureToArrowFunctionRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change closure to arrow function', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Closure::class];
    }
    /**
     * @param Closure $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\PhpVersionFeature::ARROW_FUNCTION)) {
            return null;
        }
        if (\count((array) $node->stmts) !== 1) {
            return null;
        }
        if (!$node->stmts[0] instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_) {
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
        $arrowFunction = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrowFunction();
        $arrowFunction->params = $node->params;
        $arrowFunction->returnType = $node->returnType;
        $arrowFunction->byRef = $node->byRef;
        $arrowFunction->expr = $return->expr;
        if ($node->static) {
            $arrowFunction->static = \true;
        }
        return $arrowFunction;
    }
    private function shouldSkipForUsedReferencedValue(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Closure $closure, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_ $return) : bool
    {
        if ($return->expr === null) {
            return \false;
        }
        $referencedValues = $this->resolveReferencedUseVariablesFromClosure($closure);
        if ($referencedValues === []) {
            return \false;
        }
        return (bool) $this->betterNodeFinder->findFirst([$return->expr], function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) use($referencedValues) : bool {
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
    private function resolveReferencedUseVariablesFromClosure(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Closure $closure) : array
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
