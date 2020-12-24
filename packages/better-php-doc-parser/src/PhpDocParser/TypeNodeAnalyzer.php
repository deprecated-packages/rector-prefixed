<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocParser;

use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\NullableTypeNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
/**
 * @see \Rector\BetterPhpDocParser\Tests\PhpDocParser\TypeNodeAnalyzerTest
 */
final class TypeNodeAnalyzer
{
    public function containsArrayType(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode) : bool
    {
        if ($typeNode instanceof \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            return \false;
        }
        if ($typeNode instanceof \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode) {
            return \true;
        }
        if (!$typeNode instanceof \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode) {
            return \false;
        }
        foreach ($typeNode->types as $subType) {
            if ($this->containsArrayType($subType)) {
                return \true;
            }
        }
        return \false;
    }
    public function isIntersectionAndNotNullable(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode) : bool
    {
        if (!$typeNode instanceof \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode) {
            return \false;
        }
        foreach ($typeNode->types as $subType) {
            if ($subType instanceof \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\NullableTypeNode) {
                return \false;
            }
        }
        return \true;
    }
}
