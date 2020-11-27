<?php

declare (strict_types=1);
namespace PHPStan\Analyser;

use PhpParser\Node\Expr;
use PHPStan\Type\Type;
class EnsuredNonNullabilityResultExpression
{
    /**
     * @var \PhpParser\Node\Expr
     */
    private $expression;
    /**
     * @var \PHPStan\Type\Type
     */
    private $originalType;
    /**
     * @var \PHPStan\Type\Type
     */
    private $originalNativeType;
    public function __construct(\PhpParser\Node\Expr $expression, \PHPStan\Type\Type $originalType, \PHPStan\Type\Type $originalNativeType)
    {
        $this->expression = $expression;
        $this->originalType = $originalType;
        $this->originalNativeType = $originalNativeType;
    }
    public function getExpression() : \PhpParser\Node\Expr
    {
        return $this->expression;
    }
    public function getOriginalType() : \PHPStan\Type\Type
    {
        return $this->originalType;
    }
    public function getOriginalNativeType() : \PHPStan\Type\Type
    {
        return $this->originalNativeType;
    }
}
