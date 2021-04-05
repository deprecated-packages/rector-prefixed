<?php

declare (strict_types=1);
namespace RectorPrefix20210405\Symplify\SimplePhpDocParser;

use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Ast\PhpDoc\MethodTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\MethodTagValueParameterNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocChildNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTextNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PropertyTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use PHPStan\PhpDocParser\Ast\Type\ArrayShapeItemNode;
use PHPStan\PhpDocParser\Ast\Type\ArrayShapeNode;
use PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use PHPStan\PhpDocParser\Ast\Type\CallableTypeNode;
use PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode;
use PHPStan\PhpDocParser\Ast\Type\NullableTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
/**
 * @see \Symplify\SimplePhpDocParser\Tests\SimplePhpDocNodeTraverser\PhpDocNodeTraverserTest
 */
final class PhpDocNodeTraverser
{
    public function traverseWithCallable(\PHPStan\PhpDocParser\Ast\Node $node, string $docContent, callable $callable) : \PHPStan\PhpDocParser\Ast\Node
    {
        if ($node instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode) {
            $this->traversePhpDocNode($node, $docContent, $callable);
            return $node;
        }
        if ($this->isValueNodeWithType($node)) {
            /** @var ParamTagValueNode|VarTagValueNode|ReturnTagValueNode|GenericTypeNode $node */
            if ($node->type !== null) {
                $node->type = $this->traverseTypeNode($node->type, $docContent, $callable);
            }
            return $callable($node, $docContent);
        }
        if ($node instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\MethodTagValueNode) {
            return $this->traverseMethodTagValueNode($node, $docContent, $callable);
        }
        if ($node instanceof \PHPStan\PhpDocParser\Ast\Type\TypeNode) {
            return $this->traverseTypeNode($node, $docContent, $callable);
        }
        return $callable($node, $docContent);
    }
    private function isValueNodeWithType(\PHPStan\PhpDocParser\Ast\Node $node) : bool
    {
        return $node instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\PropertyTagValueNode || $node instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode || $node instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode || $node instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode || $node instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode || $node instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\MethodTagValueParameterNode;
    }
    private function traverseTypeNode(\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, string $docContent, callable $callable) : \PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        $typeNode = $callable($typeNode, $docContent);
        if ($typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode || $typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\NullableTypeNode || $typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\GenericTypeNode) {
            $typeNode->type = $this->traverseTypeNode($typeNode->type, $docContent, $callable);
        }
        if ($typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\CallableTypeNode) {
            $typeNode->returnType = $this->traverseTypeNode($typeNode->returnType, $docContent, $callable);
            return $typeNode;
        }
        if ($typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\ArrayShapeNode) {
            $this->traverseArrayShapeNode($typeNode, $docContent, $callable);
            return $typeNode;
        }
        if ($typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\ArrayShapeItemNode) {
            $typeNode->valueType = $this->traverseTypeNode($typeNode->valueType, $docContent, $callable);
            return $typeNode;
        }
        if ($typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\GenericTypeNode) {
            $this->traverseGenericTypeNode($typeNode, $docContent, $callable);
            return $typeNode;
        }
        if ($typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\UnionTypeNode || $typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode) {
            $this->traverseUnionIntersectionType($typeNode, $docContent, $callable);
            return $typeNode;
        }
        return $typeNode;
    }
    private function traverseMethodTagValueNode(\PHPStan\PhpDocParser\Ast\PhpDoc\MethodTagValueNode $methodTagValueNode, string $docContent, callable $callable) : \PHPStan\PhpDocParser\Ast\PhpDoc\MethodTagValueNode
    {
        if ($methodTagValueNode->returnType !== null) {
            $methodTagValueNode->returnType = $this->traverseTypeNode($methodTagValueNode->returnType, $docContent, $callable);
        }
        foreach ($methodTagValueNode->parameters as $key => $methodTagValueParameterNode) {
            /** @var MethodTagValueParameterNode $methodTagValueParameterNode */
            $methodTagValueParameterNode = $this->traverseWithCallable($methodTagValueParameterNode, $docContent, $callable);
            $methodTagValueNode->parameters[$key] = $methodTagValueParameterNode;
        }
        return $callable($methodTagValueNode, $docContent);
    }
    private function traversePhpDocNode(\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode, string $docContent, callable $callable) : void
    {
        foreach ($phpDocNode->children as $key => $phpDocChildNode) {
            /** @var PhpDocChildNode $phpDocChildNode */
            $phpDocChildNode = $this->traverseWithCallable($phpDocChildNode, $docContent, $callable);
            $phpDocNode->children[$key] = $phpDocChildNode;
            if ($phpDocChildNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTextNode) {
                continue;
            }
            if (!$phpDocChildNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode) {
                continue;
            }
            /** @var PhpDocTagValueNode $traversedValue */
            $traversedValue = $this->traverseWithCallable($phpDocChildNode->value, $docContent, $callable);
            $phpDocChildNode->value = $traversedValue;
        }
    }
    private function traverseGenericTypeNode(\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode $genericTypeNode, string $docContent, callable $callable) : void
    {
        foreach ($genericTypeNode->genericTypes as $key => $genericType) {
            $genericTypeNode->genericTypes[$key] = $this->traverseTypeNode($genericType, $docContent, $callable);
        }
    }
    /**
     * @param UnionTypeNode|IntersectionTypeNode $node
     */
    private function traverseUnionIntersectionType(\PHPStan\PhpDocParser\Ast\Node $node, string $docContent, callable $callable) : void
    {
        foreach ($node->types as $key => $subTypeNode) {
            $node->types[$key] = $this->traverseTypeNode($subTypeNode, $docContent, $callable);
        }
    }
    private function traverseArrayShapeNode(\PHPStan\PhpDocParser\Ast\Type\ArrayShapeNode $arrayShapeNode, string $docContent, callable $callable) : void
    {
        foreach ($arrayShapeNode->items as $key => $itemNode) {
            $arrayShapeNode->items[$key] = $this->traverseTypeNode($itemNode, $docContent, $callable);
        }
    }
}
