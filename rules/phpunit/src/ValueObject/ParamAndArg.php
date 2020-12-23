<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PHPUnit\ValueObject;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
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
    public function __construct(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable $variable, ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type)
    {
        $this->variable = $variable;
        $this->type = $type;
    }
    public function getVariable() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable
    {
        return $this->variable;
    }
    public function getType() : ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this->type;
    }
}
