<?php

declare(strict_types=1);

namespace Symplify\SimplePhpDocParser\ValueObject\Ast\PhpDoc;

use PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;

/**
 * @noRector final on purpose, so it can be extended by 3rd party
 */
class SimplePhpDocNode extends PhpDocNode
{
    /**
     * @return \PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode|null
     */
    public function getParam(string $desiredParamName)
    {
        $desiredParamNameWithDollar = '$' . ltrim($desiredParamName, '$');

        foreach ($this->getParamTagValues() as $paramTagValueNode) {
            if ($paramTagValueNode->parameterName !== $desiredParamNameWithDollar) {
                continue;
            }

            return $paramTagValueNode;
        }

        return null;
    }

    /**
     * @return \PHPStan\PhpDocParser\Ast\Type\TypeNode|null
     */
    public function getParamType(string $desiredParamName)
    {
        $paramTagValueNode = $this->getParam($desiredParamName);
        if (! $paramTagValueNode instanceof ParamTagValueNode) {
            return null;
        }

        return $paramTagValueNode->type;
    }
}
