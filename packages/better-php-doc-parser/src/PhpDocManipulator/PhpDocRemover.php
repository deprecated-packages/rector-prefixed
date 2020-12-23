<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocManipulator;

use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
final class PhpDocRemover
{
    public function removeByName(\_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo, string $name) : void
    {
        $attributeAwarePhpDocNode = $phpDocInfo->getPhpDocNode();
        foreach ($attributeAwarePhpDocNode->children as $key => $phpDocChildNode) {
            if (!$phpDocChildNode instanceof \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode) {
                continue;
            }
            if (!$this->areAnnotationNamesEqual($name, $phpDocChildNode->name)) {
                continue;
            }
            unset($attributeAwarePhpDocNode->children[$key]);
        }
    }
    public function removeTagValueFromNode(\_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo, \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode $phpDocTagValueNode) : void
    {
        $attributeAwarePhpDocNode = $phpDocInfo->getPhpDocNode();
        foreach ($attributeAwarePhpDocNode->children as $key => $phpDocChildNode) {
            if (!$phpDocChildNode instanceof \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode) {
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
