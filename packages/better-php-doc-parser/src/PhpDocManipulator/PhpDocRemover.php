<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocManipulator;

use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
final class PhpDocRemover
{
    public function removeByName(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo, string $name) : void
    {
        $attributeAwarePhpDocNode = $phpDocInfo->getPhpDocNode();
        foreach ($attributeAwarePhpDocNode->children as $key => $phpDocChildNode) {
            if (!$phpDocChildNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode) {
                continue;
            }
            if (!$this->areAnnotationNamesEqual($name, $phpDocChildNode->name)) {
                continue;
            }
            unset($attributeAwarePhpDocNode->children[$key]);
        }
    }
    public function removeTagValueFromNode(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo, \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode $phpDocTagValueNode) : void
    {
        $attributeAwarePhpDocNode = $phpDocInfo->getPhpDocNode();
        foreach ($attributeAwarePhpDocNode->children as $key => $phpDocChildNode) {
            if (!$phpDocChildNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode) {
                continue;
            }
            if ($phpDocChildNode->value !== $phpDocTagValueNode) {
                continue;
            }
            unset($attributeAwarePhpDocNode->children[$key]);
        }
    }
    private function areAnnotationNamesEqual(string $firstAnnotationName, string $secondAnnotationName) : bool
    {
        $firstAnnotationName = \trim($firstAnnotationName, '@');
        $secondAnnotationName = \trim($secondAnnotationName, '@');
        return $firstAnnotationName === $secondAnnotationName;
    }
}
