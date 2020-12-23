<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Sensio\NodeFactory;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\FuncCallManipulator;
final class ArrayFromCompactFactory
{
    /**
     * @var FuncCallManipulator
     */
    private $funcCallManipulator;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\FuncCallManipulator $funcCallManipulator)
    {
        $this->funcCallManipulator = $funcCallManipulator;
    }
    public function createArrayFromCompactFuncCall(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $compactFuncCall) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_
    {
        $compactVariableNames = $this->funcCallManipulator->extractArgumentsFromCompactFuncCalls([$compactFuncCall]);
        $array = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_();
        foreach ($compactVariableNames as $compactVariableName) {
            $arrayItem = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable($compactVariableName), new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_($compactVariableName));
            $array->items[] = $arrayItem;
        }
        return $array;
    }
}
