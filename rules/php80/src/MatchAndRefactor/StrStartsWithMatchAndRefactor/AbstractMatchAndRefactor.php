<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php80\MatchAndRefactor\StrStartsWithMatchAndRefactor;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Value\ValueResolver;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\Php80\ValueObject\StrStartsWith;
abstract class AbstractMatchAndRefactor
{
    /**
     * @var NodeNameResolver
     */
    protected $nodeNameResolver;
    /**
     * @var ValueResolver
     */
    protected $valueResolver;
    /**
     * @var BetterStandardPrinter
     */
    protected $betterStandardPrinter;
    /**
     * @required
     */
    public function autowireAbstractMatchAndRefactor(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter) : void
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->valueResolver = $valueResolver;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    protected function isFuncCallName(\_PhpScopere8e811afab72\PhpParser\Node $node, string $name) : bool
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall) {
            return \false;
        }
        return $this->nodeNameResolver->isName($node, $name);
    }
    /**
     * @return FuncCall|BooleanNot
     */
    protected function createStrStartsWith(\_PhpScopere8e811afab72\Rector\Php80\ValueObject\StrStartsWith $strStartsWith) : \_PhpScopere8e811afab72\PhpParser\Node
    {
        $args = [new \_PhpScopere8e811afab72\PhpParser\Node\Arg($strStartsWith->getHaystackExpr()), new \_PhpScopere8e811afab72\PhpParser\Node\Arg($strStartsWith->getNeedleExpr())];
        $funcCall = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall(new \_PhpScopere8e811afab72\PhpParser\Node\Name('str_starts_with'), $args);
        if ($strStartsWith->isPositive()) {
            return $funcCall;
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot($funcCall);
    }
    protected function createStrStartsWithValueObjectFromFuncCall(\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $funcCall, bool $isPositive) : \_PhpScopere8e811afab72\Rector\Php80\ValueObject\StrStartsWith
    {
        $haystack = $funcCall->args[0]->value;
        $needle = $funcCall->args[1]->value;
        return new \_PhpScopere8e811afab72\Rector\Php80\ValueObject\StrStartsWith($funcCall, $haystack, $needle, $isPositive);
    }
}
