<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PhpDocParser;

use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Ast\Type\ArrayShapeItemNode;
use PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use PHPStan\PhpDocParser\Ast\Type\CallableTypeNode;
use PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode;
use PHPStan\PhpDocParser\Ast\Type\NullableTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocAttributeKey;
use RectorPrefix20210405\Symplify\SimplePhpDocParser\PhpDocNodeTraverser;
final class ParentNodeTraverser
{
    /**
     * @var PhpDocNodeTraverser
     */
    private $phpDocNodeTraverser;
    public function __construct(\RectorPrefix20210405\Symplify\SimplePhpDocParser\PhpDocNodeTraverser $phpDocNodeTraverser)
    {
        $this->phpDocNodeTraverser = $phpDocNodeTraverser;
    }
    /**
     * Connects parent types with children types
     */
    public function transform(\PHPStan\PhpDocParser\Ast\Node $node, string $docContent) : \PHPStan\PhpDocParser\Ast\Node
    {
        return $this->phpDocNodeTraverser->traverseWithCallable($node, $docContent, function (\PHPStan\PhpDocParser\Ast\Node $node) : Node {
            if (!$node instanceof \PHPStan\PhpDocParser\Ast\Type\TypeNode) {
                return $node;
            }
            if ($node instanceof \PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode || $node instanceof \PHPStan\PhpDocParser\Ast\Type\GenericTypeNode || $node instanceof \PHPStan\PhpDocParser\Ast\Type\NullableTypeNode) {
                $node->type->setAttribute(\Rector\BetterPhpDocParser\ValueObject\PhpDocAttributeKey::PARENT, $node);
            }
            if ($node instanceof \PHPStan\PhpDocParser\Ast\Type\CallableTypeNode) {
                $node->returnType->setAttribute(\Rector\BetterPhpDocParser\ValueObject\PhpDocAttributeKey::PARENT, $node);
            }
            if ($node instanceof \PHPStan\PhpDocParser\Ast\Type\ArrayShapeItemNode) {
                $node->valueType->setAttribute(\Rector\BetterPhpDocParser\ValueObject\PhpDocAttributeKey::PARENT, $node);
            }
            if ($node instanceof \PHPStan\PhpDocParser\Ast\Type\UnionTypeNode || $node instanceof \PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode) {
                foreach ($node->types as $unionedType) {
                    $unionedType->setAttribute(\Rector\BetterPhpDocParser\ValueObject\PhpDocAttributeKey::PARENT, $node);
                }
            }
            if ($node instanceof \PHPStan\PhpDocParser\Ast\Type\GenericTypeNode) {
                foreach ($node->genericTypes as $genericType) {
                    $genericType->setAttribute(\Rector\BetterPhpDocParser\ValueObject\PhpDocAttributeKey::PARENT, $node);
                }
            }
            return $node;
        });
    }
}
