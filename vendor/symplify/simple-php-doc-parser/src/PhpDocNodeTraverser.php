<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\SimplePhpDocParser;

use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTextNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PropertyTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\NullableTypeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
final class PhpDocNodeTraverser
{
    public function traverseWithCallable(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, string $docContent, callable $callable) : void
    {
        foreach ($phpDocNode->children as $key => $phpDocChildNode) {
            $phpDocChildNode = $callable($phpDocChildNode);
            $phpDocNode->children[$key] = $phpDocChildNode;
            if ($phpDocChildNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTextNode) {
                continue;
            }
            if (!$phpDocChildNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode) {
                continue;
            }
            $phpDocChildNode->value = $callable($phpDocChildNode->value, $docContent);
            if ($this->isValueNodeWithType($phpDocChildNode->value)) {
                /** @var ParamTagValueNode|VarTagValueNode|ReturnTagValueNode|GenericTypeNode $valueNode */
                $valueNode = $phpDocChildNode->value;
                $valueNode->type = $this->traverseTypeNode($valueNode->type, $docContent, $callable);
            }
        }
    }
    private function isValueNodeWithType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode $phpDocTagValueNode) : bool
    {
        return $phpDocTagValueNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PropertyTagValueNode || $phpDocTagValueNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode || $phpDocTagValueNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode || $phpDocTagValueNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode || $phpDocTagValueNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode;
    }
    private function traverseTypeNode(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, string $docContent, callable $callable) : \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        $typeNode = $callable($typeNode, $docContent);
        if ($typeNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode || $typeNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\NullableTypeNode || $typeNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode) {
            $typeNode->type = $this->traverseTypeNode($typeNode->type, $docContent, $callable);
        }
        if ($typeNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode) {
            foreach ($typeNode->genericTypes as $key => $genericType) {
                $typeNode->genericTypes[$key] = $this->traverseTypeNode($genericType, $docContent, $callable);
            }
        }
        if ($typeNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode || $typeNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode) {
            foreach ($typeNode->types as $key => $subTypeNode) {
                $typeNode->types[$key] = $this->traverseTypeNode($subTypeNode, $docContent, $callable);
            }
        }
        return $typeNode;
    }
}
