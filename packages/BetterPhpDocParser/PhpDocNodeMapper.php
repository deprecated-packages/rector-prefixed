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
use Rector\BetterPhpDocParser\ValueObject\PhpDoc\SpacingAwareTemplateTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDoc\VariadicAwareParamTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\Type\BracketsAwareIntersectionTypeNode;
use Rector\BetterPhpDocParser\ValueObject\Type\BracketsAwareUnionTypeNode;
use Rector\BetterPhpDocParser\ValueObject\Type\SpacingAwareArrayShapeItemNode;
use Rector\BetterPhpDocParser\ValueObject\Type\SpacingAwareArrayTypeNode;
use Rector\BetterPhpDocParser\ValueObject\Type\SpacingAwareCallableTypeNode;
use RectorPrefix20210327\Symplify\SimplePhpDocParser\PhpDocNodeTraverser;
/**
 * @see \Rector\Tests\BetterPhpDocParser\PhpDocNodeMapperTest
 */
final class PhpDocNodeMapper
{
    /**
     * @var PhpDocNodeTraverser
     */
    private $phpDocNodeTraverser;
    public function __construct(\RectorPrefix20210327\Symplify\SimplePhpDocParser\PhpDocNodeTraverser $phpDocNodeTraverser)
    {
        $this->phpDocNodeTraverser = $phpDocNodeTraverser;
    }
    /**
     * @template T of \PHPStan\PhpDocParser\Ast\Node
     * @param T $node
     * @return T
     */
    public function transform(\PHPStan\PhpDocParser\Ast\Node $node, string $docContent) : \PHPStan\PhpDocParser\Ast\Node
    {
        $transformingCallable = function (\PHPStan\PhpDocParser\Ast\Node $node, string $docContent) : Node {
            if ($node instanceof \PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode && !$node instanceof \Rector\BetterPhpDocParser\ValueObject\Type\BracketsAwareIntersectionTypeNode) {
                return new \Rector\BetterPhpDocParser\ValueObject\Type\BracketsAwareIntersectionTypeNode($node->types);
            }
            if ($node instanceof \PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode && !$node instanceof \Rector\BetterPhpDocParser\ValueObject\Type\SpacingAwareArrayTypeNode) {
                return new \Rector\BetterPhpDocParser\ValueObject\Type\SpacingAwareArrayTypeNode($node->type);
            }
            if ($node instanceof \PHPStan\PhpDocParser\Ast\Type\CallableTypeNode && !$node instanceof \Rector\BetterPhpDocParser\ValueObject\Type\SpacingAwareCallableTypeNode) {
                return new \Rector\BetterPhpDocParser\ValueObject\Type\SpacingAwareCallableTypeNode($node->identifier, $node->parameters, $node->returnType);
            }
            if ($node instanceof \PHPStan\PhpDocParser\Ast\Type\UnionTypeNode && !$node instanceof \Rector\BetterPhpDocParser\ValueObject\Type\BracketsAwareUnionTypeNode) {
                return new \Rector\BetterPhpDocParser\ValueObject\Type\BracketsAwareUnionTypeNode($node->types, $docContent);
            }
            if ($node instanceof \PHPStan\PhpDocParser\Ast\Type\ArrayShapeItemNode && !$node instanceof \Rector\BetterPhpDocParser\ValueObject\Type\SpacingAwareArrayShapeItemNode) {
                return new \Rector\BetterPhpDocParser\ValueObject\Type\SpacingAwareArrayShapeItemNode($node->keyName, $node->optional, $node->valueType, $docContent);
            }
            if ($node instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode && !$node instanceof \Rector\BetterPhpDocParser\ValueObject\PhpDoc\SpacingAwareTemplateTagValueNode) {
                return new \Rector\BetterPhpDocParser\ValueObject\PhpDoc\SpacingAwareTemplateTagValueNode($node->name, $node->bound, $node->description, $docContent);
            }
            if ($node instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode && !$node instanceof \Rector\BetterPhpDocParser\ValueObject\PhpDoc\VariadicAwareParamTagValueNode) {
                return new \Rector\BetterPhpDocParser\ValueObject\PhpDoc\VariadicAwareParamTagValueNode($node->type, $node->isVariadic, $node->parameterName, $node->description);
            }
            return $node;
        };
        return $this->phpDocNodeTraverser->traverseWithCallable($node, $docContent, $transformingCallable);
    }
}
