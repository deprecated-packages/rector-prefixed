<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Sensio\NodeFactory;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\FuncCallManipulator;
final class ArrayFromCompactFactory
{
    /**
     * @var FuncCallManipulator
     */
    private $funcCallManipulator;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\FuncCallManipulator $funcCallManipulator)
    {
        $this->funcCallManipulator = $funcCallManipulator;
    }
    public function createArrayFromCompactFuncCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $compactFuncCall) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_
    {
        $compactVariableNames = $this->funcCallManipulator->extractArgumentsFromCompactFuncCalls([$compactFuncCall]);
        $array = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_();
        foreach ($compactVariableNames as $compactVariableName) {
            $arrayItem = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable($compactVariableName), new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_($compactVariableName));
            $array->items[] = $arrayItem;
        }
        return $array;
    }
}
