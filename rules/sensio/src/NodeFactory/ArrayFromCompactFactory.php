<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Sensio\NodeFactory;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Array_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Manipulator\FuncCallManipulator;
final class ArrayFromCompactFactory
{
    /**
     * @var FuncCallManipulator
     */
    private $funcCallManipulator;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Manipulator\FuncCallManipulator $funcCallManipulator)
    {
        $this->funcCallManipulator = $funcCallManipulator;
    }
    public function createArrayFromCompactFuncCall(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $compactFuncCall) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Array_
    {
        $compactVariableNames = $this->funcCallManipulator->extractArgumentsFromCompactFuncCalls([$compactFuncCall]);
        $array = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Array_();
        foreach ($compactVariableNames as $compactVariableName) {
            $arrayItem = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayItem(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable($compactVariableName), new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_($compactVariableName));
            $array->items[] = $arrayItem;
        }
        return $array;
    }
}
