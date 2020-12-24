<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\ValueObject;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Closure;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
final class VariableAndCallForeach
{
    /**
     * @var string
     */
    private $variableName;
    /**
     * @var Variable
     */
    private $variable;
    /**
     * @var FuncCall|MethodCall|StaticCall
     */
    private $call;
    /**
     * @var ClassMethod|Function_|Closure
     */
    private $functionLike;
    /**
     * @param FuncCall|StaticCall|MethodCall $expr
     * @param ClassMethod|Function_|Closure $functionLike
     */
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $variable, \_PhpScopere8e811afab72\PhpParser\Node\Expr $expr, string $variableName, \_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike)
    {
        $this->variable = $variable;
        $this->call = $expr;
        $this->variableName = $variableName;
        $this->functionLike = $functionLike;
    }
    public function getVariable() : \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable
    {
        return $this->variable;
    }
    /**
     * @return FuncCall|StaticCall|MethodCall
     */
    public function getCall() : \_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        return $this->call;
    }
    public function getVariableName() : string
    {
        return $this->variableName;
    }
    /**
     * @return ClassMethod|Function_|Closure
     */
    public function getFunctionLike() : \_PhpScopere8e811afab72\PhpParser\Node\FunctionLike
    {
        return $this->functionLike;
    }
}
