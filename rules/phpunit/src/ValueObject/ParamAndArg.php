<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\PHPUnit\ValueObject;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable $variable, ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type)
    {
        $this->variable = $variable;
        $this->type = $type;
    }
    public function getVariable() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable
    {
        return $this->variable;
    }
    public function getType() : ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return $this->type;
    }
}
