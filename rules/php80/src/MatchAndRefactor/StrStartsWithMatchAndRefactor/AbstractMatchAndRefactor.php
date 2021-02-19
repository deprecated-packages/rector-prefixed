<?php

declare (strict_types=1);
namespace Rector\Php80\MatchAndRefactor\StrStartsWithMatchAndRefactor;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\BooleanNot;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use Rector\Core\PhpParser\Comparing\NodeComparator;
use Rector\Core\PhpParser\Node\Value\ValueResolver;
use Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\Php80\ValueObject\StrStartsWith;
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
     * @var NodeComparator
     */
    protected $nodeComparator;
    /**
     * @required
     */
    public function autowireAbstractMatchAndRefactor(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver, \Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \Rector\Core\PhpParser\Comparing\NodeComparator $nodeComparator) : void
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->valueResolver = $valueResolver;
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->nodeComparator = $nodeComparator;
    }
    protected function isFuncCallName(\PhpParser\Node $node, string $name) : bool
    {
        if (!$node instanceof \PhpParser\Node\Expr\FuncCall) {
            return \false;
        }
        return $this->nodeNameResolver->isName($node, $name);
    }
    /**
     * @return FuncCall|BooleanNot
     */
    protected function createStrStartsWith(\Rector\Php80\ValueObject\StrStartsWith $strStartsWith) : \PhpParser\Node
    {
        $args = [new \PhpParser\Node\Arg($strStartsWith->getHaystackExpr()), new \PhpParser\Node\Arg($strStartsWith->getNeedleExpr())];
        $funcCall = new \PhpParser\Node\Expr\FuncCall(new \PhpParser\Node\Name('str_starts_with'), $args);
        if ($strStartsWith->isPositive()) {
            return $funcCall;
        }
        return new \PhpParser\Node\Expr\BooleanNot($funcCall);
    }
    protected function createStrStartsWithValueObjectFromFuncCall(\PhpParser\Node\Expr\FuncCall $funcCall, bool $isPositive) : \Rector\Php80\ValueObject\StrStartsWith
    {
        $haystack = $funcCall->args[0]->value;
        $needle = $funcCall->args[1]->value;
        return new \Rector\Php80\ValueObject\StrStartsWith($funcCall, $haystack, $needle, $isPositive);
    }
}
