<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\ValueObject;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Function_;
use _PhpScoper0a6b37af0871\Rector\Naming\Contract\RenameParamValueObjectInterface;
final class ParamRename implements \_PhpScoper0a6b37af0871\Rector\Naming\Contract\RenameParamValueObjectInterface
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
    public function __construct(string $currentName, string $expectedName, \_PhpScoper0a6b37af0871\PhpParser\Node\Param $param, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable $variable, \_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike $functionLike)
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
    public function getFunctionLike() : \_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike
    {
        return $this->functionLike;
    }
    public function getParam() : \_PhpScoper0a6b37af0871\PhpParser\Node\Param
    {
        return $this->param;
    }
    public function getVariable() : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable
    {
        return $this->variable;
    }
}
