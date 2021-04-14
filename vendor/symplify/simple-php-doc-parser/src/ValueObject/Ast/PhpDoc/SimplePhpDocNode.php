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
    public function getParam(string $desiredParamName): ?ParamTagValueNode
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

    public function getParamType(string $desiredParamName): ?TypeNode
    {
        $paramTagValueNode = $this->getParam($desiredParamName);
        if (! $paramTagValueNode instanceof ParamTagValueNode) {
            return null;
        }

        return $paramTagValueNode->type;
    }
}
