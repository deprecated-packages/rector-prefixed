<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\SimplePhpDocParser\ValueObject\Ast\PhpDoc;

use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode;
/**
 * @notfinal on purpose, so it can be extended by 3rd party
 */
class SimplePhpDocNode extends \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode
{
    public function getParam(string $desiredParamName) : ?\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode
    {
        $desiredParamNameWithDollar = '$' . \ltrim($desiredParamName, '$');
        foreach ($this->getParamTagValues() as $paramTagValueNode) {
            if ($paramTagValueNode->parameterName !== $desiredParamNameWithDollar) {
                continue;
            }
            return $paramTagValueNode;
        }
        return null;
    }
    public function getParamType(string $desiredParamName) : ?\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        $paramTagValueNode = $this->getParam($desiredParamName);
        if ($paramTagValueNode === null) {
            return null;
        }
        return $paramTagValueNode->type;
    }
}
