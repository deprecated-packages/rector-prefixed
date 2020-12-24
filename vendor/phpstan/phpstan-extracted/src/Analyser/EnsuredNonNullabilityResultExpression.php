<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Analyser;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
class EnsuredNonNullabilityResultExpression
{
    /** @var Expr */
    private $expression;
    /** @var Type */
    private $originalType;
    /** @var Type */
    private $originalNativeType;
    public function __construct(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expression, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $originalType, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $originalNativeType)
    {
        $this->expression = $expression;
        $this->originalType = $originalType;
        $this->originalNativeType = $originalNativeType;
    }
    public function getExpression() : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        return $this->expression;
    }
    public function getOriginalType() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return $this->originalType;
    }
    public function getOriginalNativeType() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return $this->originalNativeType;
    }
}
