<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\TypeInferer;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Param;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface;
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
    public function inferParam(\_PhpScoper0a2ac50786fa\PhpParser\Node\Param $param) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        foreach ($this->paramTypeInferers as $paramTypeInferer) {
            $type = $paramTypeInferer->inferParam($param);
            if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType) {
                continue;
            }
            return $type;
        }
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
    }
}
