<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Order;

use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\PHPStan\Type\ArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\BooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\CallableType;
use _PhpScoper0a6b37af0871\PHPStan\Type\FloatType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntegerType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntersectionType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IterableType;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\StringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\NotImplementedException;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
final class PropertyRanker
{
    public function rank(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property) : int
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return 1;
        }
        $varType = $phpDocInfo->getVarType();
        if ($varType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\StringType || $varType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType || $varType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\BooleanType || $varType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\FloatType) {
            return 5;
        }
        if ($varType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType || $varType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IterableType) {
            return 10;
        }
        if ($varType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName) {
            return 15;
        }
        if ($varType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntersectionType) {
            return 20;
        }
        if ($varType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType) {
            return 25;
        }
        if ($varType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType) {
            return 30;
        }
        if ($varType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\CallableType) {
            return 35;
        }
        throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\NotImplementedException(\get_class($varType));
    }
}
