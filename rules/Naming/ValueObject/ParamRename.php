<?php

declare (strict_types=1);
namespace Rector\Naming\ValueObject;

use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use Rector\Naming\Contract\RenameParamValueObjectInterface;
final class ParamRename implements \Rector\Naming\Contract\RenameParamValueObjectInterface
{
    /**
     * @var string
     */
    private $currentName;
    /**
     * @var string
     */
    private $expectedName;
    /**
     * @var \PhpParser\Node\Param
     */
    private $param;
    /**
     * @var \PhpParser\Node\Expr\Variable
     */
    private $variable;
    /**
     * @var \PhpParser\Node\FunctionLike
     */
    private $functionLike;
    public function __construct(string $currentName, string $expectedName, \PhpParser\Node\Param $param, \PhpParser\Node\Expr\Variable $variable, \PhpParser\Node\FunctionLike $functionLike)
    {
        $this->currentName = $currentName;
        $this->expectedName = $expectedName;
        $this->param = $param;
        $this->variable = $variable;
        $this->functionLike = $functionLike;
    }
    public function getCurrentName() : string
    {
        return $this->currentName;
    }
    public function getExpectedName() : string
    {
        return $this->expectedName;
    }
    /**
     * @return ClassMethod|Function_|Closure
     */
    public function getFunctionLike() : \PhpParser\Node\FunctionLike
    {
        return $this->functionLike;
    }
    public function getParam() : \PhpParser\Node\Param
    {
        return $this->param;
    }
    public function getVariable() : \PhpParser\Node\Expr\Variable
    {
        return $this->variable;
    }
}
