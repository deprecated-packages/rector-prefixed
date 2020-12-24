<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php80\MatchAndRefactor\StrStartsWithMatchAndRefactor;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Value\ValueResolver;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\Php80\ValueObject\StrStartsWith;
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
    public function autowireAbstractMatchAndRefactor(\_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter) : void
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->valueResolver = $valueResolver;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    protected function isFuncCallName(\_PhpScoperb75b35f52b74\PhpParser\Node $node, string $name) : bool
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall) {
            return \false;
        }
        return $this->nodeNameResolver->isName($node, $name);
    }
    /**
     * @return FuncCall|BooleanNot
     */
    protected function createStrStartsWith(\_PhpScoperb75b35f52b74\Rector\Php80\ValueObject\StrStartsWith $strStartsWith) : \_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $args = [new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($strStartsWith->getHaystackExpr()), new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($strStartsWith->getNeedleExpr())];
        $funcCall = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name('str_starts_with'), $args);
        if ($strStartsWith->isPositive()) {
            return $funcCall;
        }
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot($funcCall);
    }
    protected function createStrStartsWithValueObjectFromFuncCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $funcCall, bool $isPositive) : \_PhpScoperb75b35f52b74\Rector\Php80\ValueObject\StrStartsWith
    {
        $haystack = $funcCall->args[0]->value;
        $needle = $funcCall->args[1]->value;
        return new \_PhpScoperb75b35f52b74\Rector\Php80\ValueObject\StrStartsWith($funcCall, $haystack, $needle, $isPositive);
    }
}
