<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Analyser;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
class EnsuredNonNullabilityResultExpression
{
    /** @var Expr */
    private $expression;
    /** @var Type */
    private $originalType;
    /** @var Type */
    private $originalNativeType;
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expression, \_PhpScopere8e811afab72\PHPStan\Type\Type $originalType, \_PhpScopere8e811afab72\PHPStan\Type\Type $originalNativeType)
    {
        $this->expression = $expression;
        $this->originalType = $originalType;
        $this->originalNativeType = $originalNativeType;
    }
    public function getExpression() : \_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        return $this->expression;
    }
    public function getOriginalType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->originalType;
    }
    public function getOriginalNativeType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->originalNativeType;
    }
}
