<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocManipulator;

use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a6b37af0871\Rector\Naming\Contract\RenameValueObjectInterface;
use _PhpScoper0a6b37af0871\Rector\Naming\ValueObject\ParamRename;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
final class PropertyDocBlockManipulator
{
    /**
     * @param ParamRename $renameValueObject
     */
    public function renameParameterNameInDocBlock(\_PhpScoper0a6b37af0871\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : void
    {
        $functionLike = $renameValueObject->getFunctionLike();
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $functionLike->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
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
