<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PhpDocManipulator;

use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\Naming\Contract\RenameValueObjectInterface;
use Rector\Naming\ValueObject\ParamRename;
final class PropertyDocBlockManipulator
{
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    public function __construct(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory)
    {
        $this->phpDocInfoFactory = $phpDocInfoFactory;
    }
    /**
     * @param ParamRename $renameValueObject
     */
    public function renameParameterNameInDocBlock(\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : void
    {
        $functionLike = $renameValueObject->getFunctionLike();
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($functionLike);
        $paramTagValueNode = $phpDocInfo->getParamTagValueNodeByName($renameValueObject->getCurrentName());
        if ($paramTagValueNode === null) {
            return;
        }
        $paramTagValueNode->parameterName = '$' . $renameValueObject->getExpectedName();
    }
}
