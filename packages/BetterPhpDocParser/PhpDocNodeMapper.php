<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser;

use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode;
use PHPStan\PhpDocParser\Ast\Type\ArrayShapeItemNode;
use PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use PHPStan\PhpDocParser\Ast\Type\CallableTypeNode;
use PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode;
use PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use Rector\BetterPhpDocParser\PhpDocInfo\TokenIteratorFactory;
use Rector\BetterPhpDocParser\PhpDocParser\ParentNodeTraverser;
use Rector\BetterPhpDocParser\ValueObject\PhpDoc\SpacingAwareTemplateTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDoc\VariadicAwareParamTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\StartAndEnd;
use Rector\BetterPhpDocParser\ValueObject\Type\BracketsAwareIntersectionTypeNode;
use Rector\BetterPhpDocParser\ValueObject\Type\BracketsAwareUnionTypeNode;
use Rector\BetterPhpDocParser\ValueObject\Type\SpacingAwareArrayShapeItemNode;
use Rector\BetterPhpDocParser\ValueObject\Type\SpacingAwareArrayTypeNode;
use Rector\BetterPhpDocParser\ValueObject\Type\SpacingAwareCallableTypeNode;
use RectorPrefix20210404\Symplify\SimplePhpDocParser\PhpDocNodeTraverser;
/**
 * @see \Rector\Tests\BetterPhpDocParser\PhpDocNodeMapperTest
 */
final class PhpDocNodeMapper
{
    /**
     * @var PhpDocNodeTraverser
     */
    private $phpDocNodeTraverser;
    /**
     * @var TokenIteratorFactory
     */
    private $tokenIteratorFactory;
    /**
     * @var ParentNodeTraverser
     */
    private $parentNodeTraverser;
    public function __construct(\RectorPrefix20210404\Symplify\SimplePhpDocParser\PhpDocNodeTraverser $phpDocNodeTraverser, \Rector\BetterPhpDocParser\PhpDocInfo\TokenIteratorFactory $tokenIteratorFactory, \Rector\BetterPhpDocParser\PhpDocParser\ParentNodeTraverser $parentNodeTraverser)
    {
        $this->phpDocNodeTraverser = $phpDocNodeTraverser;
        $this->tokenIteratorFactory = $tokenIteratorFactory;
        $this->parentNodeTraverser = $parentNodeTraverser;
    }
    /**
     * @template T of \PHPStan\PhpDocParser\Ast\Node
     * @param T $node
     * @return T
     */
    public function transform(\PHPStan\PhpDocParser\Ast\Node $node, string $docContent) : \PHPStan\PhpDocParser\Ast\Node
    {
        $node = $this->parentNodeTraverser->transform($node, $docContent);
        $betterTokenIterator = $this->tokenIteratorFactory->create($docContent);
        // connect parent types with children types
        $transformingCallable = function (\PHPStan\PhpDocParser\Ast\Node $node, string $docContent) use($betterTokenIterator) : Node {
            // narrow to node-specific doc content
            $startAndEnd = $node->getAttribute(\Rector\BetterPhpDocParser\ValueObject\StartAndEnd::class);
            if ($startAndEnd instanceof \Rector\BetterPhpDocParser\ValueObject\StartAndEnd) {
                $parentTypeNode = $node->getAttribute('parent');
                if ($parentTypeNode instanceof \PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode) {
                    $docContent = $betterTokenIterator->printFromTo($startAndEnd->getStart() - 1, $startAndEnd->getEnd() + 1);
                } else {
                    $docContent = $betterTokenIterator->printFromTo($startAndEnd->getStart(), $startAndEnd->getEnd());
                }
            }
            if ($node instanceof \PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode && !$node instanceof \Rector\BetterPhpDocParser\ValueObject\Type\BracketsAwareIntersectionTypeNode) {
                $bracketsAwareIntersectionTypeNode = new \Rector\BetterPhpDocParser\ValueObject\Type\BracketsAwareIntersectionTypeNode($node->types);
                $this->mirrorAttributes($node, $bracketsAwareIntersectionTypeNode);
                return $bracketsAwareIntersectionTypeNode;
            }
            if ($node instanceof \PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode && !$node instanceof \Rector\BetterPhpDocParser\ValueObject\Type\SpacingAwareArrayTypeNode) {
                $spacingAwareArrayTypeNode = new \Rector\BetterPhpDocParser\ValueObject\Type\SpacingAwareArrayTypeNode($node->type);
                $this->mirrorAttributes($node, $spacingAwareArrayTypeNode);
                return $spacingAwareArrayTypeNode;
            }
            if ($node instanceof \PHPStan\PhpDocParser\Ast\Type\CallableTypeNode && !$node instanceof \Rector\BetterPhpDocParser\ValueObject\Type\SpacingAwareCallableTypeNode) {
                $spacingAwareCallableTypeNode = new \Rector\BetterPhpDocParser\ValueObject\Type\SpacingAwareCallableTypeNode($node->identifier, $node->parameters, $node->returnType);
                $this->mirrorAttributes($node, $spacingAwareCallableTypeNode);
                return $spacingAwareCallableTypeNode;
            }
            if ($node instanceof \PHPStan\PhpDocParser\Ast\Type\UnionTypeNode && !$node instanceof \Rector\BetterPhpDocParser\ValueObject\Type\BracketsAwareUnionTypeNode) {
                // if has parent of array, widen the type
                $bracketsAwareUnionTypeNode = new \Rector\BetterPhpDocParser\ValueObject\Type\BracketsAwareUnionTypeNode($node->types, $docContent);
                $this->mirrorAttributes($node, $bracketsAwareUnionTypeNode);
                return $bracketsAwareUnionTypeNode;
            }
            if ($node instanceof \PHPStan\PhpDocParser\Ast\Type\ArrayShapeItemNode && !$node instanceof \Rector\BetterPhpDocParser\ValueObject\Type\SpacingAwareArrayShapeItemNode) {
                $spacingAwareArrayShapeItemNode = new \Rector\BetterPhpDocParser\ValueObject\Type\SpacingAwareArrayShapeItemNode($node->keyName, $node->optional, $node->valueType, $docContent);
                $this->mirrorAttributes($node, $spacingAwareArrayShapeItemNode);
                return $spacingAwareArrayShapeItemNode;
            }
            if ($node instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode && !$node instanceof \Rector\BetterPhpDocParser\ValueObject\PhpDoc\SpacingAwareTemplateTagValueNode) {
                $spacingAwareTemplateTagValueNode = new \Rector\BetterPhpDocParser\ValueObject\PhpDoc\SpacingAwareTemplateTagValueNode($node->name, $node->bound, $node->description, $docContent);
                $this->mirrorAttributes($node, $spacingAwareTemplateTagValueNode);
                return $spacingAwareTemplateTagValueNode;
            }
            if ($node instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode && !$node instanceof \Rector\BetterPhpDocParser\ValueObject\PhpDoc\VariadicAwareParamTagValueNode) {
                $variadicAwareParamTagValueNode = new \Rector\BetterPhpDocParser\ValueObject\PhpDoc\VariadicAwareParamTagValueNode($node->type, $node->isVariadic, $node->parameterName, $node->description);
                $this->mirrorAttributes($node, $variadicAwareParamTagValueNode);
                return $variadicAwareParamTagValueNode;
            }
            return $node;
        };
        return $this->phpDocNodeTraverser->traverseWithCallable($node, $docContent, $transformingCallable);
    }
    private function mirrorAttributes(\PHPStan\PhpDocParser\Ast\Node $oldNode, \PHPStan\PhpDocParser\Ast\Node $newNode) : void
    {
        $newNode->setAttribute(\Rector\BetterPhpDocParser\ValueObject\StartAndEnd::class, $oldNode->getAttribute(\Rector\BetterPhpDocParser\ValueObject\StartAndEnd::class));
    }
}
