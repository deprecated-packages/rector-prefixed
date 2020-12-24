<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\ValueObject;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Function_;
final class VariableAndCallAssign
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
     * @var Assign
     */
    private $assign;
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
    public function __construct(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable $variable, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign $assign, string $variableName, \_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike $functionLike)
    {
        $this->variable = $variable;
        $this->call = $expr;
        $this->variableName = $variableName;
        $this->functionLike = $functionLike;
        $this->assign = $assign;
    }
    public function getVariable() : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable
    {
        return $this->variable;
    }
    /**
     * @return FuncCall|StaticCall|MethodCall
     */
    public function getCall() : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr
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
    public function getFunctionLike() : \_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike
    {
        return $this->functionLike;
    }
    public function getAssign() : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign
    {
        return $this->assign;
    }
}
