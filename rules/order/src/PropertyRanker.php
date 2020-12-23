<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Order;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\CallableType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\FloatType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\IntersectionType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\IterableType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\StringType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName;
use _PhpScoper0a2ac50786fa\PHPStan\Type\UnionType;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\NotImplementedException;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
final class PropertyRanker
{
    public function rank(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property $property) : int
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return 1;
        }
        $varType = $phpDocInfo->getVarType();
        if ($varType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\StringType || $varType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType || $varType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType || $varType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\FloatType) {
            return 5;
        }
        if ($varType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType || $varType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\IterableType) {
            return 10;
        }
        if ($varType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName) {
            return 15;
        }
        if ($varType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\IntersectionType) {
            return 20;
        }
        if ($varType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType) {
            return 25;
        }
        if ($varType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType) {
            return 30;
        }
        if ($varType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\CallableType) {
            return 35;
        }
        throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\NotImplementedException(\get_class($varType));
    }
}
