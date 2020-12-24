<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
class EnsuredNonNullabilityResultExpression
{
    /** @var Expr */
    private $expression;
    /** @var Type */
    private $originalType;
    /** @var Type */
    private $originalNativeType;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $expression, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $originalType, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $originalNativeType)
    {
        $this->expression = $expression;
        $this->originalType = $originalType;
        $this->originalNativeType = $originalNativeType;
    }
    public function getExpression() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr
    {
        return $this->expression;
    }
    public function getOriginalType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return $this->originalType;
    }
    public function getOriginalNativeType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return $this->originalNativeType;
    }
}
