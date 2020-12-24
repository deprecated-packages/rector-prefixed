<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Value\ValueResolver;
final class FuncCallManipulator
{
    /**
     * @var ValueResolver
     */
    private $valueResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver)
    {
        $this->valueResolver = $valueResolver;
    }
    /**
     * @param FuncCall[] $compactFuncCalls
     * @return string[]
     */
    public function extractArgumentsFromCompactFuncCalls(array $compactFuncCalls) : array
    {
        $arguments = [];
        foreach ($compactFuncCalls as $compactFuncCall) {
            foreach ($compactFuncCall->args as $arg) {
                $value = $this->valueResolver->getValue($arg->value);
                if ($value === null) {
                    continue;
                }
                $arguments[] = $value;
            }
        }
        return $arguments;
    }
}
