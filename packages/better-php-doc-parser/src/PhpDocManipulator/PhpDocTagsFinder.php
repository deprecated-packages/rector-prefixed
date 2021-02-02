<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PhpDocManipulator;

use PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use RectorPrefix20210202\Symplify\SimplePhpDocParser\SimplePhpDocParser;
/**
 * @see \Rector\BetterPhpDocParser\Tests\PhpDocManipulator\PhpDocTagsFinderTest
 */
final class PhpDocTagsFinder
{
    /**
     * @var SimplePhpDocParser
     */
    private $simplePhpDocParser;
    public function __construct(\RectorPrefix20210202\Symplify\SimplePhpDocParser\SimplePhpDocParser $simplePhpDocParser)
    {
        $this->simplePhpDocParser = $simplePhpDocParser;
    }
    /**
     * @return string[]
     */
    public function extractTrowsTypesFromDocBlock(string $docBlock) : array
    {
        $simplePhpDocNode = $this->simplePhpDocParser->parseDocBlock($docBlock);
        return $this->resolveTypes($simplePhpDocNode->getThrowsTagValues());
    }
    /**
     * @param ThrowsTagValueNode[]|ReturnTagValueNode[] $tagValueNodes
     * @return string[]
     */
    private function resolveTypes(array $tagValueNodes) : array
    {
        $types = [];
        foreach ($tagValueNodes as $tagValueNode) {
            $typeNode = $tagValueNode->type;
            if ($typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
                $types[] = $typeNode->name;
            }
            if ($typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\UnionTypeNode) {
                $types = \array_merge($types, $this->resolveUnionType($typeNode));
            }
        }
        return $types;
    }
    /**
     * @return string[]
     */
    private function resolveUnionType(\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode $unionTypeNode) : array
    {
        $types = [];
        foreach ($unionTypeNode->types as $unionedType) {
            if ($unionedType instanceof \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
                $types[] = $unionedType->name;
            }
        }
        return $types;
    }
}
