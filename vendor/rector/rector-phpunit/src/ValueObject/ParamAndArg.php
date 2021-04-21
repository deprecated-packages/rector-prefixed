<?php

declare(strict_types=1);

namespace Rector\PHPUnit\ValueObject;

use PhpParser\Node\Expr\Variable;
use PHPStan\Type\Type;

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

    /**
     * @param \PHPStan\Type\Type|null $type
     */
    public function __construct(Variable $variable, $type)
    {
        $this->variable = $variable;
        $this->type = $type;
    }

    public function getVariable(): Variable
    {
        return $this->variable;
    }

    /**
     * @return \PHPStan\Type\Type|null
     */
    public function getType()
    {
        return $this->type;
    }
}
