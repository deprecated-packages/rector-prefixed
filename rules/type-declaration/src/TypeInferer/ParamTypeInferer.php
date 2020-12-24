<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer;

use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface;
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
    public function inferParam(\_PhpScoperb75b35f52b74\PhpParser\Node\Param $param) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        foreach ($this->paramTypeInferers as $paramTypeInferer) {
            $type = $paramTypeInferer->inferParam($param);
            if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
                continue;
            }
            return $type;
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
    }
}
