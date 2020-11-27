<?php

declare (strict_types=1);
namespace Rector\Order;

use PhpParser\Node\Stmt\Property;
use PHPStan\Type\ArrayType;
use PHPStan\Type\BooleanType;
use PHPStan\Type\CallableType;
use PHPStan\Type\FloatType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\IterableType;
use PHPStan\Type\MixedType;
use PHPStan\Type\StringType;
use PHPStan\Type\TypeWithClassName;
use PHPStan\Type\UnionType;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\Core\Exception\NotImplementedException;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class PropertyRanker
{
    public function rank(\PhpParser\Node\Stmt\Property $property) : int
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return 1;
        }
        $varType = $phpDocInfo->getVarType();
        if ($varType instanceof \PHPStan\Type\StringType || $varType instanceof \PHPStan\Type\IntegerType || $varType instanceof \PHPStan\Type\BooleanType || $varType instanceof \PHPStan\Type\FloatType) {
            return 5;
        }
        if ($varType instanceof \PHPStan\Type\ArrayType || $varType instanceof \PHPStan\Type\IterableType) {
            return 10;
        }
        if ($varType instanceof \PHPStan\Type\TypeWithClassName) {
            return 15;
        }
        if ($varType instanceof \PHPStan\Type\IntersectionType) {
            return 20;
        }
        if ($varType instanceof \PHPStan\Type\UnionType) {
            return 25;
        }
        if ($varType instanceof \PHPStan\Type\MixedType) {
            return 30;
        }
        if ($varType instanceof \PHPStan\Type\CallableType) {
            return 35;
        }
        throw new \Rector\Core\Exception\NotImplementedException(\get_class($varType));
    }
}
