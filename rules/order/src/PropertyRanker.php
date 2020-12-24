<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Order;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\BooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\CallableType;
use _PhpScopere8e811afab72\PHPStan\Type\FloatType;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\IntersectionType;
use _PhpScopere8e811afab72\PHPStan\Type\IterableType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\StringType;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\Core\Exception\NotImplementedException;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class PropertyRanker
{
    public function rank(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : int
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return 1;
        }
        $varType = $phpDocInfo->getVarType();
        if ($varType instanceof \_PhpScopere8e811afab72\PHPStan\Type\StringType || $varType instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntegerType || $varType instanceof \_PhpScopere8e811afab72\PHPStan\Type\BooleanType || $varType instanceof \_PhpScopere8e811afab72\PHPStan\Type\FloatType) {
            return 5;
        }
        if ($varType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType || $varType instanceof \_PhpScopere8e811afab72\PHPStan\Type\IterableType) {
            return 10;
        }
        if ($varType instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
            return 15;
        }
        if ($varType instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType) {
            return 20;
        }
        if ($varType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            return 25;
        }
        if ($varType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return 30;
        }
        if ($varType instanceof \_PhpScopere8e811afab72\PHPStan\Type\CallableType) {
            return 35;
        }
        throw new \_PhpScopere8e811afab72\Rector\Core\Exception\NotImplementedException(\get_class($varType));
    }
}
