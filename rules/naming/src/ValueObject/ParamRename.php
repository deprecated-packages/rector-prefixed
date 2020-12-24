<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Naming\ValueObject;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Closure;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Function_;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Contract\RenameParamValueObjectInterface;
final class ParamRename implements \_PhpScoper2a4e7ab1ecbc\Rector\Naming\Contract\RenameParamValueObjectInterface
{
    /**
     * @var string
     */
    private $expectedName;
    /**
     * @var string
     */
    private $currentName;
    /**
     * @var Param
     */
    private $param;
    /**
     * @var Variable
     */
    private $variable;
    /**
     * @var ClassMethod|Function_|Closure
     */
    private $functionLike;
    /**
     * @param ClassMethod|Function_|Closure $functionLike
     */
    public function __construct(string $currentName, string $expectedName, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param $param, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable $variable, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike $functionLike)
    {
        $this->param = $param;
        $this->variable = $variable;
        $this->expectedName = $expectedName;
        $this->currentName = $currentName;
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
    public function getFunctionLike() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike
    {
        return $this->functionLike;
    }
    public function getParam() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param
    {
        return $this->param;
    }
    public function getVariable() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable
    {
        return $this->variable;
    }
}
