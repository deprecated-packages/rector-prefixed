<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Sensio\NodeFactory;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\Array_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\FuncCallManipulator;
final class ArrayFromCompactFactory
{
    /**
     * @var FuncCallManipulator
     */
    private $funcCallManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\FuncCallManipulator $funcCallManipulator)
    {
        $this->funcCallManipulator = $funcCallManipulator;
    }
    public function createArrayFromCompactFuncCall(\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $compactFuncCall) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_
    {
        $compactVariableNames = $this->funcCallManipulator->extractArgumentsFromCompactFuncCalls([$compactFuncCall]);
        $array = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_();
        foreach ($compactVariableNames as $compactVariableName) {
            $arrayItem = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($compactVariableName), new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_($compactVariableName));
            $array->items[] = $arrayItem;
        }
        return $array;
    }
}
