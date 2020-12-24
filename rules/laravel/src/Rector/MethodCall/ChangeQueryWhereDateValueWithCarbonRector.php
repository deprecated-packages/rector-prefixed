<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Laravel\Rector\MethodCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/laravel/framework/pull/25315
 * @see https://laracasts.com/discuss/channels/eloquent/laravel-eloquent-where-date-is-equal-or-smaller-than-datetime
 *
 * @see \Rector\Laravel\Tests\Rector\MethodCall\ChangeQueryWhereDateValueWithCarbonRector\ChangeQueryWhereDateValueWithCarbonRectorTest
 */
final class ChangeQueryWhereDateValueWithCarbonRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('_PhpScoper0a6b37af0871\\Add parent::boot(); call to boot() class method in child of Illuminate\\Database\\Eloquent\\Model', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Illuminate\Database\Query\Builder;

final class SomeClass
{
    public function run(Builder $query)
    {
        $query->whereDate('created_at', '<', Carbon::now());
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Illuminate\Database\Query\Builder;

final class SomeClass
{
    public function run(Builder $query)
    {
        $dateTime = Carbon::now();
        $query->whereDate('created_at', '<=', $dateTime);
        $query->whereTime('created_at', '<=', $dateTime);
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $argValue = $this->matchWhereDateThirdArgValue($node);
        if ($argValue === null) {
            return null;
        }
        // is just made with static call?
        if ($argValue instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall || $argValue instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
            // now!
            // 1. extract assign
            $dateTimeVariable = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable('dateTime');
            $assign = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign($dateTimeVariable, $argValue);
            $this->addNodeBeforeNode($assign, $node);
            $node->args[2]->value = $dateTimeVariable;
            // update assign ">" → ">="
            $this->changeCompareSignExpr($node->args[1]);
            // 2. add "whereTime()" time call
            $whereTimeMethodCall = $this->createWhereTimeMethodCall($node, $dateTimeVariable);
            $this->addNodeAfterNode($whereTimeMethodCall, $node);
            return $node;
        }
        if ($argValue instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable) {
            $dateTimeVariable = $argValue;
            $this->changeCompareSignExpr($node->args[1]);
            // 2. add "whereTime()" time call
            $whereTimeMethodCall = $this->createWhereTimeMethodCall($node, $dateTimeVariable);
            $this->addNodeAfterNode($whereTimeMethodCall, $node);
        }
        return null;
    }
    private function matchWhereDateThirdArgValue(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        if (!$this->isOnClassMethodCall($methodCall, '_PhpScoper0a6b37af0871\\Illuminate\\Database\\Query\\Builder', 'whereDate')) {
            return null;
        }
        if (!isset($methodCall->args[2])) {
            return null;
        }
        $argValue = $methodCall->args[2]->value;
        if (!$this->isObjectType($argValue, 'DateTimeInterface')) {
            return null;
        }
        // nothing to change
        if ($this->isStaticCallNamed($argValue, '_PhpScoper0a6b37af0871\\Carbon\\Carbon', 'today')) {
            return null;
        }
        if ($this->isValues($methodCall->args[1]->value, ['>=', '<='])) {
            return null;
        }
        return $argValue;
    }
    private function changeCompareSignExpr(\_PhpScoper0a6b37af0871\PhpParser\Node\Arg $arg) : void
    {
        if (!$arg->value instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_) {
            return;
        }
        $string = $arg->value;
        if ($string->value === '<') {
            $string->value = '<=';
        }
        if ($string->value === '>') {
            $string->value = '>=';
        }
    }
    private function createWhereTimeMethodCall(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable $dateTimeVariable) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall
    {
        $whereTimeArgs = [$methodCall->args[0], $methodCall->args[1], new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($dateTimeVariable)];
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall($methodCall->var, 'whereTime', $whereTimeArgs);
    }
}
