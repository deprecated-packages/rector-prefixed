<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Php80\MatchAndRefactor\StrStartsWithMatchAndRefactor;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BooleanNot;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Value\ValueResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\Php80\ValueObject\StrStartsWith;
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
    public function autowireAbstractMatchAndRefactor(\_PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver, \_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter) : void
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->valueResolver = $valueResolver;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    protected function isFuncCallName(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, string $name) : bool
    {
        if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall) {
            return \false;
        }
        return $this->nodeNameResolver->isName($node, $name);
    }
    /**
     * @return FuncCall|BooleanNot
     */
    protected function createStrStartsWith(\_PhpScoper2a4e7ab1ecbc\Rector\Php80\ValueObject\StrStartsWith $strStartsWith) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        $args = [new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg($strStartsWith->getHaystackExpr()), new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg($strStartsWith->getNeedleExpr())];
        $funcCall = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name('str_starts_with'), $args);
        if ($strStartsWith->isPositive()) {
            return $funcCall;
        }
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BooleanNot($funcCall);
    }
    protected function createStrStartsWithValueObjectFromFuncCall(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $funcCall, bool $isPositive) : \_PhpScoper2a4e7ab1ecbc\Rector\Php80\ValueObject\StrStartsWith
    {
        $haystack = $funcCall->args[0]->value;
        $needle = $funcCall->args[1]->value;
        return new \_PhpScoper2a4e7ab1ecbc\Rector\Php80\ValueObject\StrStartsWith($funcCall, $haystack, $needle, $isPositive);
    }
}
