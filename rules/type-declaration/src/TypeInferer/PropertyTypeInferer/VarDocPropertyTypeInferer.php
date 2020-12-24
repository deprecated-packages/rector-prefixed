<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class VarDocPropertyTypeInferer
{
    public function inferProperty(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : ?\_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return null;
        }
        // is empty
        if ($phpDocInfo->getPhpDocNode()->children === []) {
            return null;
        }
        return $phpDocInfo->getVarType();
    }
}
