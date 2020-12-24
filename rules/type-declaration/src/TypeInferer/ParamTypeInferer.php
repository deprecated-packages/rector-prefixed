<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer;

use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface;
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
    public function inferParam(\_PhpScoper0a6b37af0871\PhpParser\Node\Param $param) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        foreach ($this->paramTypeInferers as $paramTypeInferer) {
            $type = $paramTypeInferer->inferParam($param);
            if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType) {
                continue;
            }
            return $type;
        }
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
    }
}
