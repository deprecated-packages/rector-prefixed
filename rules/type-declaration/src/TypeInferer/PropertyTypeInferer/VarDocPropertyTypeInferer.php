<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
final class VarDocPropertyTypeInferer
{
    public function inferProperty(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property $property) : ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return null;
        }
        // is empty
        if ($phpDocInfo->getPhpDocNode()->children === []) {
            return null;
        }
        return $phpDocInfo->getVarType();
    }
}
