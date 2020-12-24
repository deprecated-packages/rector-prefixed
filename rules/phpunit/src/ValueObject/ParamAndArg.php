<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPUnit\ValueObject;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
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
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $variable, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $type)
    {
        $this->variable = $variable;
        $this->type = $type;
    }
    public function getVariable() : \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable
    {
        return $this->variable;
    }
    public function getType() : ?\_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->type;
    }
}
