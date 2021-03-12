<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\TypeComparator;

use PHPStan\Type\BooleanType;
use PHPStan\Type\FloatType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
/**
 * @see \Rector\Tests\NodeTypeResolver\TypeComparator\ScalarTypeComparatorTest
 */
final class ScalarTypeComparator
{
    public function areEqualScalar(\PHPStan\Type\Type $firstType, \PHPStan\Type\Type $secondType) : bool
    {
        if ($firstType instanceof \PHPStan\Type\StringType && $secondType instanceof \PHPStan\Type\StringType) {
            // prevents "class-string" vs "string"
            return \get_class($firstType) === \get_class($secondType);
        }
        if ($firstType instanceof \PHPStan\Type\IntegerType && $secondType instanceof \PHPStan\Type\IntegerType) {
            return \true;
        }
        if ($firstType instanceof \PHPStan\Type\FloatType && $secondType instanceof \PHPStan\Type\FloatType) {
            return \true;
        }
        if (!$firstType instanceof \PHPStan\Type\BooleanType) {
            return \false;
        }
        return $secondType instanceof \PHPStan\Type\BooleanType;
    }
}
