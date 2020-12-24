<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocManipulator;

use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\Naming\Contract\RenameValueObjectInterface;
use _PhpScopere8e811afab72\Rector\Naming\ValueObject\ParamRename;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class PropertyDocBlockManipulator
{
    /**
     * @param ParamRename $renameValueObject
     */
    public function renameParameterNameInDocBlock(\_PhpScopere8e811afab72\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : void
    {
        $functionLike = $renameValueObject->getFunctionLike();
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $functionLike->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return;
        }
        $paramTagValueNode = $phpDocInfo->getParamTagValueNodeByName($renameValueObject->getCurrentName());
        if ($paramTagValueNode === null) {
            return;
        }
        $paramTagValueNode->parameterName = '$' . $renameValueObject->getExpectedName();
    }
}
