<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPUnit\ValueObject;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
final class ParamAndArg
{
    /**
     * @var Variable
     */
    private $variable;
    /**
     * @var Type|null
     */
    private $type;
    public function __construct(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable $variable, ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type)
    {
        $this->variable = $variable;
        $this->type = $type;
    }
    public function getVariable() : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable
    {
        return $this->variable;
    }
    public function getType() : ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return $this->type;
    }
}
