<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer;

use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface;
final class ParamTypeInferer
{
    /**
     * @var ParamTypeInfererInterface[]
     */
    private $paramTypeInferers = [];
    /**
     * @param ParamTypeInfererInterface[] $paramTypeInferers
     */
    public function __construct(array $paramTypeInferers)
    {
        $this->paramTypeInferers = $paramTypeInferers;
    }
    public function inferParam(\_PhpScopere8e811afab72\PhpParser\Node\Param $param) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        foreach ($this->paramTypeInferers as $paramTypeInferer) {
            $type = $paramTypeInferer->inferParam($param);
            if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
                continue;
            }
            return $type;
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
    }
}
