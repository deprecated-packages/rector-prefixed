<?php

namespace _PhpScoperbd5d0c5f7638\SpecifiedTypesClosureUse;

use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Identifier;
use function PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo(\PhpParser\Node\Expr\MethodCall $call, \PhpParser\Node\Expr\MethodCall $bar) : void
    {
        if ($call->name instanceof \PhpParser\Node\Identifier && $bar->name instanceof \PhpParser\Node\Identifier) {
            function () use($call) : void {
                \PHPStan\Analyser\assertType('PhpParser\\Node\\Identifier', $call->name);
                \PHPStan\Analyser\assertType('mixed', $bar->name);
            };
            \PHPStan\Analyser\assertType('PhpParser\\Node\\Identifier', $call->name);
        }
    }
    public function doBar(\PhpParser\Node\Expr\MethodCall $call, \PhpParser\Node\Expr\MethodCall $bar) : void
    {
        if ($call->name instanceof \PhpParser\Node\Identifier && $bar->name instanceof \PhpParser\Node\Identifier) {
            $a = 1;
            function () use($call, &$a) : void {
                \PHPStan\Analyser\assertType('PhpParser\\Node\\Identifier', $call->name);
                \PHPStan\Analyser\assertType('mixed', $bar->name);
            };
            \PHPStan\Analyser\assertType('PhpParser\\Node\\Identifier', $call->name);
        }
    }
}
