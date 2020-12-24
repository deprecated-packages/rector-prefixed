<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Analyser;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
class EnsuredNonNullabilityResultExpression
{
    /** @var Expr */
    private $expression;
    /** @var Type */
    private $originalType;
    /** @var Type */
    private $originalNativeType;
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expression, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $originalType, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $originalNativeType)
    {
        $this->expression = $expression;
        $this->originalType = $originalType;
        $this->originalNativeType = $originalNativeType;
    }
    public function getExpression() : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        return $this->expression;
    }
    public function getOriginalType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->originalType;
    }
    public function getOriginalNativeType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->originalNativeType;
    }
}
